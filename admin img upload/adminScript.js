var formfield = '';
var imgfield = '';
var storeSendToEditor = '';
var newSendToEditor = '';
jQuery(document).ready(function() {

    storeSendToEditor = window.send_to_editor;
    newSendToEditor = function(html) {
        imgurl = jQuery(html).attr('href');
        jQuery('#' + formfield).val(imgurl);
        jQuery('#' + imgfield).attr('src', imgurl);
        tb_remove();
        window.send_to_editor = storeSendToEditor;
    }
});


function Uploader(fieldId, imgId) {
    window.send_to_editor = newSendToEditor;
    formfield = fieldId;
    imgfield = imgId;
    tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
    return false;
}