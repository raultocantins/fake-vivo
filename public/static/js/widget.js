(function($){

    $.widget("vivo.warning", {
        options: {
            type: 'warning',
            text: '',
            // Callbacks
            change: null
        },

        _create: function () {
            this.element
                .addClass('toastr-container');
            this.toastr
                .addClass('toastr toastr-' + this.type);
            this.mess
        }
    });

})(jQuery);