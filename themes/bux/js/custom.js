var j$ = jQuery.noConflict();
/**
 * Vertically center Bootstrap 3 modals so they aren't always stuck at the top
 */
j$(function() {
  function reposition() {
    var modal = j$(this);
    var dialog = modal.find('.modal-dialog');
    modal.css('display', 'block');

    // Dividing by two centers the modal exactly, but dividing by three
    // or four works better for larger screens.
    dialog.css('margin-top',
      Math.max(0, (j$(window).height() - dialog.height()) / 2));
  }
  // Reposition when a modal is shown
  j$('.modal').on('show.bs.modal', reposition);
  // Reposition when the window is resized
  j$(window).on('resize', function() {
    j$('.modal:visible').each(reposition);
  });
});

Dropzone.options.buxDropzone = {
  paramName: "bux_multiple_attachments",
  addRemoveLinks: "dictRemoveFile" // The name that will be used to transfer the file
};