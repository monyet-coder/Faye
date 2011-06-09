FAYE.UI.UITypeahead = function(el) {
	const KEY_UP 		= 38;
	const KEY_BACK 		= 8;
	const KEY_DOWN 		= 40;	
	const KEY_ENTER 	= 13;
	const KEY_ESCAPE 	= 27;
	
	if(this === FAYE.UI) {
		return new FAYE.UI.UITypeahead(el);
	}
	
	if(el.nodeName !== 'FORM') {
		return false;
	}
	
	var self = this,
		data = [],	
		activeIndex = -1,
		suggestionItemMarkup = '<li class="Suggestion-Item"></li>',
		
		$form = $(el),
		$text = $('input.UI-Text-Field', $form),
		$dataSource = $('input.Source-Holder', $form),
		$holder = $('ul.UI-Typeahead-Placeholder', $form),
		isRemote = $form.hasClass('Remote-Source');
	
	var getData = function() {
			if(!isRemote){
				self.data = $.parseJSON($dataSource.val());
			}
		},
		getRemoteData = function(keyword, callback) {
			$.getJSON($dataSource.val().replace('{keyword}', keyword), function(response) {
				self.data = response;
				
				(callback || function(){})(self.data);
			});
		},
		searchSuggestion = function(keyword, callback) {
			if(keyword == '') {
				return [];
			}
			
			var result = [];
			
			if(isRemote) {
				getRemoteData(keyword, callback || function() {});
			} else {				
				for(var i in this.data) {
					if(this.data[i].toLowerCase().indexOf(keyword) !== -1) {
						result.push(this.data[i]);
					}
				}
				
				callback(result);
			}
			
			return true;
		},
		showSuggestion =  function(keyword) {
			searchSuggestion(keyword, refresh);
		}, 
		refresh = function(suggestion) {
			if(suggestion.length === 0) {
				closeSuggestion();
				
				return;
			}
	
			$holder.empty().css({
				width : $text.width(),
				top : 0,
			}).show();
			
			for(i in suggestion) {
				$(suggestionItemMarkup).
					append(suggestion[i]).
					appendTo($holder);
			}
			
			$('li', $holder).click(function() {
				chooseSuggestion(this);
			});
		},
		closeSuggestion = function() {
			activeIndex = -1;
			$holder.hide();
		},
		markSuggestion = function() {
			if($holder.is(':visible')) {
				$li = $('li', $holder);
				$li.filter('.active').removeClass('active');
				$li.eq(activeIndex % $li.length).addClass('active');
			}
		}, 
		chooseSuggestion = function(chosen) {
			if ($holder.is(':visible')) {
				$li = $('li', $holder);
				
				$text.val(chosen && chosen.innerHTML || $li.eq(activeIndex % $li.length).html());
				
				closeSuggestion();
				
				$holder.hide();
				
				$form.submit(false);
			} else {
				$form.unbind('submit');
			}
		};
	
	this.data = data;
	this.searchSuggestion = searchSuggestion;
	this.showSuggestion = showSuggestion;
	this.closeSuggestion = closeSuggestion;
	this.markSuggestion = markSuggestion;
	this.chooseSuggestion = chooseSuggestion;
	
	getData();
	$form.submit(function(e) {
		//console.log($text.val());
		alert('anjing');
		return false;
	});
	
	$text.keydown(function(e) {
		switch(e.keyCode) {
			case KEY_ESCAPE : 
				closeSuggestion();
			break;
			case KEY_ENTER:
				chooseSuggestion();
			break;
			case KEY_DOWN:
				++activeIndex;
				markSuggestion();
			break;
			case KEY_UP:
				--activeIndex;
				markSuggestion();
			break;
			case KEY_BACK:
				var keyword = this.value.slice(0, -1);
				console.log(keyword);
				if(keyword) {
					showSuggestion(keyword);
				} else {
					closeSuggestion();
				}
			break;
			default:
				showSuggestion(this.value + String.fromCharCode(e.keyCode).toLowerCase());
		}
	});
}

jQuery(function($) {
	$('.UI-Typeahead').each(function() {
		new FAYE.UI.UITypeahead(this);
	});
});