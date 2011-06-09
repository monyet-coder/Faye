FAYE.UI.UIText = (function($, undefined) {
	return {
		GhostText : function(element) {
			this.element = element;
			
			$(this.element).
				data('GhostText', this.element.value).
				focus(function() {
					if(this.value === $(this).data('GhostText')) {
						$(this).removeClass('Ghost-Text').val('');
					}
				}).
				blur(function(){
					if(this.value === '') {
						this.value = $(this).data('GhostText');
						
						$(this).addClass('Ghost-Text');
					}
				});
		},
	};
}(jQuery));

$(function() {
	$('input.Ghost-Text').each(function() {
		new FAYE.UI.UIText.GhostText(this);
	});
});
