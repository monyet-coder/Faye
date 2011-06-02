<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	App::import('libraries.ui.*');
	
	class UIController extends Controller {
		public function index() {
			$options = array(
				'1' => 'Category 1',
				'2' => 'Category 2',
			);
			
			$combo = new UIComboBox($options);
			$combo->selectedIndex(1);
			
			
			$radio = new UIRadioGroup($options);
			$radio->name = 'CategoryID';
			$radio->selectedIndex(1);
			
			
			$check = new UICheckGroup($options);
			$check->selectedIndex(1);
			
			
			$textfield = new UITextField();
			$textfield->ghostText = 'Input your password ...';
			
			$text2 = new UITextField();
			$text2->ghostText = 'Some other content ..';
			
			$button = new UIButton();
			$button->setIcon('http://www.mricons.com/store/png/118067_35637_16_accept_check_icon.png')->setText('Save');

			$header = array('Product ID', 'Product Name', 'Product Price');
			$rows = array(
				array(1, 'First Product', '$ 10.000'),
				array(2, 'Second Product', 'Rp. 120.000.000'),
			);
			
			array_unshift($rows, $header);
			
			$grid = new UIGrid($rows);
			$grid->hideColumn(1);
			
			$list = new UIList($options);
			
			$form = new UIForm();
			$form->async('http://localhost/fork');
			$form->append($text2, $button->setType(button::SUBMIT));
			
			$listbox = new UIListBox(array(
				'1' => 'Item 1',
				'2' => 'Item 2',
				'3' => 'Item 3',
				'4' => 'Item 4',
				'5' => 'Item 5',
				'6' => 'Item 6',
				'7' => 'Item 7',
				'8' => 'Item 8',
			));
			
			$listbox->size = 5;
			$listbox->selectedIndex(4);
			$listbox->selectedIndex(1);
			
			$typeahead = new UITypeahead();
			$typeahead->setSource(array(
				'Java', 
				'PHP', 
				'C', 
				'C++', 
				'C#', 
				'Visual Basic', 
				'Javascript', 
				'Erlang', 
				'Ruby', 
				'Perl', 
				'Python', 
				'jQuery', 
				'CSS', 
				'HTML',
				'Hadoop',
				'Thrift',
				'Scribe',
				'Hive',
				'XHP',
				'Memcached',
				'MapReduce',
				'HipHop',
				'Haskell',
				'Scheme',
				'Lisp',
				'Ada',
			));
			
			$breadcrumb = new UIBreadcrumb(array(
				App::basePath() => 'Home',
				App::basePath('demo') => 'Demo',
			));
			
			$notification = new UINotification(array(
				'First Notification ever !!!',
				'well, it\'s the second',
				'and i\'m only the third',
				'First Notification ever !!!',
				'well, it\'s the second',
				'and i\'m only the third',
				'First Notification ever !!!',
				'well, it\'s the second',
				'and i\'m only the third',
				'First Notification ever !!!',
				'well, it\'s the second',
				'and i\'m only the third',
				'First Notification ever !!!',
				'well, it\'s the second',
				'and i\'m only the third',
				'First Notification ever !!!',
				'well, it\'s the second',
				'and i\'m only the third',
				'First Notification ever !!!',
				'well, it\'s the second',
				'and i\'m only the third',
			));
			
			$this->load->lib('Benchmark');

			$link = new UILink('http://localhost');	
			
			$this->load->lib('UserAgent');
			
			$indexPage = $this->view->load('UI');
			
			$indexPage->vars = array(
				'TITLE'		=> 'UI Components',
				'CONTENT' 	=> 'Web Application Content',
				'COMBO_BOX'	=> $combo,
				'BUTTON'	=> $button,
				'GRID'		=> $grid,
				'RADIO'		=> $radio,
				'CHECK'		=> $check,
				'TEXTFIELD'	=> $textfield,
				'LIST'		=> $list,
				'TEXTAREA'	=> new UITextArea(),
				'TEXT'		=> new UIText('This is text.'),
				'TEXT2'	=> $text2,
				'FORM'		=> $form,
				'LISTBOX'	=> $listbox,
				'TYPEAHEAD' => $typeahead,
				'USERAGENT'=> 'My browser : ' . UserAgent::getInstance()->browser,
				'BREADCRUMB' => $breadcrumb,
				'NOTIFICATION' => $notification,
				'LINK'		=> $link,
			);
			
			$this->load->lib('jQuery');
			
			echo $indexPage;
		}
		
		public function ajax() {
			$this->load->lib('jQuery');
			
			jQuery(function() {
				jQuery('h1')->click(function() {
					jQuery('.UI-List li')->append(' Appended.');
					
					jQuery('.UI-List li')->click(function() {
						jQuery(this)->append(' asd1');
					});
					
					return false;
				});
			})->inject();
		}
	}