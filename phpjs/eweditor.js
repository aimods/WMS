// override tinyMCE.DOM.get method
tinymce.DOM.get = function(e) {
	if (e && this.doc && typeof(e) == 'string') {
		if (/^(f[\w]+)\$(x[\w]+)\$$/.test(e)) { // get the textarea
			var f = this.doc.getElementById(RegExp.$1);
			e = (f) ? ew_GetElement(RegExp.$2, f) : null;
		} else { // get other elements
			e = this.doc.getElementById(e);
		}
	}
	return e;
}

// create editor
function ew_CreateEditor(formid, name, cols, rows, readonly) {
	if (typeof tinymce == "undefined" || name.indexOf("$rowindex$") > -1)
		return;
	var $ = jQuery, form = $("#" + formid)[0], el = ew_GetElement(name, form);
	if (!el)
		return;
	var w = (cols ? Math.abs(cols) : 35) * 2 + "em"; // width
	var h = ((rows ? Math.abs(rows) : 4) + 4) * 1.5 + "em"; // height
	var settings = {

		//width: w, // DO NOT specify width when creating editor
		height: h,
		language: EW_LANGUAGE_ID || "",
		theme: "modern",
		plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste"
		],
		toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		toolbar2: "print preview media | forecolor backcolor emoticons"
	};
	var args = {"id": name, "form": form, "enabled": true, "settings": settings};
	$(document).trigger("create.editor", [args]);
	if (!args.enabled)
		return;
	if (readonly) {
		new ew_ReadOnlyTextArea(el, w, h);
	} else {
		var longname = formid + "$" + name + "$";
		var editor = {
			name: name,
			active: false,
			instance: null,
			create: function() { // create
				var ed = this.instance = tinymce.EditorManager.createEditor(longname,  args.settings);
				$(function() {
					ed.render(true);
				});
				this.active = true;
			},
			set: function() { // update value from textarea to editor
				if (this.instance) this.instance.setContent(el.value);
			},
			save: function() { // update value from textarea to editor
				if (this.instance) this.instance.save();
				var args = {"id": name, "form": form, "value": ew_RemoveSpaces(el.value)};
				$(document).trigger("save.editor", [args]).val(args.value);
			},
			focus: function() { // focus editor
				if (this.instance) this.instance.focus(false);
			},
			destroy: function() { // destroy
				if (this.instance) tinymce.remove(this.instance);
				this.active = false;
			}
		};
		$(el).data("editor", editor).addClass("editor");
	}
}
