FAYE.UI.UIForm = (function($){	
	return {
		onReady : function(){
			$('form.Async').submit(function() {
				var $this = $(this);
				var action = $('input.Async-Action', $this).val() || $this.attr('action');
				var serialize = $this.serialize();
				
				if($this.hasClass('Submitting')) {
					return false
				};

				$this.addClass('Submitting');
				$('input, select, textarea, button', $this).attr('disabled', 'disabled');
				$.post(action, serialize, function() {
					$('input, select, textarea, button', $this).removeAttr('disabled');
					$this.removeClass('Submitting');
				});
				
				return false;
			});
		},
	};	
}(jQuery));

$(FAYE.UI.UIForm.onReady);