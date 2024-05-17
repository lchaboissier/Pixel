// Charge le fichier scss
require('../scss/back.scss');

require('../../node_modules/tinymce/tinymce')
require('../../node_modules/tinymce/models/dom/index')
require('../../node_modules/tinymce/themes/silver/index')
require('../../node_modules/tinymce/icons/default/index')

tinymce.init({
    selector: 'textarea.wysiwyg'
})

import 'bootstrap'
