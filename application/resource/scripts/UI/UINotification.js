jQuery(function($) {
	FAYE.UI.UINotification = (function () {
		var $el = $('.UI-Notification'),
			$li = $el.find('li');
		
		var UINotificationItem = function(el) {
			if(el.nodeName !== 'LI') {
				return;
			}
			
			var $el = $(el),
				self = this;
			
			this.close = function() {
				$el.animate({opacity : 0}).slideUp(function() {
					$(this).remove();
				});
				
				return this;
			};
			$el.find('a.Close').click(function() {
				self.close();
				
				return false;
			});
		};
		
		return {
			items : (function() {
				var items = [];
				$li.each(function(i, el) {
					items.push(new UINotificationItem(this));
				});
				
				return items;
			}()),
			closeAll : function() {
				var i;
				
				for(i = 0; i < this.items.length; ++i) {
					this.items[i].close();
				}
				
				return this;
			},
			UINotificationItem : UINotificationItem,
		};
	}());
});