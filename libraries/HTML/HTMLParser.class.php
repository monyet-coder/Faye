<?php
    defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

    /**
     * HTML Parser
     *
     * Class that transforms html to array as best as it's able
     * 
     * @author Ciprian Mocanu <http://mbe.ro/> <ciprian@mbe.ro>
     * @version 1.02
     * 
     **/
    App::load()->lib('XMLNode', 'XML');
    
    class HtmlParser {
        /**
         * String that a simple tag will be transformed into
         *
         * @var string
         */
        public $separator = '-{}-'; 
        /**
         * Single tags: The tags like <img /> (which end in /> and don't have any innerhtml in them)
         *
         * @var string
         */
        public $singleTags = 'meta|img|hr|br|link|!--|!DOCTYPE|input|col';

        //-- Don't edit below this --

        private $html, $level, $aSingleTags, $aSimpleTags, $idArray, $cacheArray, $nSingleTags, $nSimpleTags;
        public $ignoreSingleTags;

        function __construct($html='') {
            if ($html!='') {
                $this->html=$this->removeWhiteSpace($html);
            }
            $this->level=-1;
            $this->idArray = array();
            $this->ignoreSingleTags = false;
        }
        function __destruct() {
            //nothing yet;
        }
        private function getElement($id) {
            return $this->cacheArray[$id];
        }
        private function addTag($id, $htmlText, $tag, $attr, $innerHtml, $singleTag=false) {

            if (!$singleTag || !$this->ignoreSingleTags) {
                $_id = $this->separator.$this->level.'-'.$id.$this->separator;

                $this->idArray [$_id]= array(
                    'tag'       => $tag,
                    'id'        => $_id,                    
                    'innerHTML' => $innerHtml,
                    'htmlText'  => $htmlText,
                    'attribute' => XMLNode::parseAttributes($attr),
                    'parent'    => NULL,
                    'children'  => array()
                );

                if ($this->level>0) {
                    if (strpos($innerHtml,$this->separator)!==false) { //has any unchanged tags in them
                        $ar=explode($this->separator,$innerHtml);
                        for ($i=0;$i<(count($ar)-1)/2;$i++) {
                            $item = $this->separator.$ar[$i*2+1].$this->separator;

                            $element = $this->getElement ($item);
                            $element ['parent'] = $_id;

                            $this->idArray [$_id]['children'] []= $element;

                            $innerHtml = str_replace($item,$element['htmlText'],$innerHtml);
                            unset($this->idArray[$item]);
                        }
                        $this->idArray [$_id]['innerHTML'] = $innerHtml;
                        $this->idArray [$_id]['htmlText'] = XMLNode::markup($tag, XMLNode::parseAttributes($attr), $innerHTML, $singleTag);
                    }
                }

                $this->cacheArray [$_id] = $this->idArray [$_id];
                $this->html = str_replace($htmlText,$_id,$this->html);
            } else {
                $this->html = str_replace($htmlText,'',$this->html);
            }
        }
        private function removeWhiteSpace ($string='') {
            $string = str_replace(array("\n","\r",'&nbsp;',"\t"),'',$string);
            return preg_replace('|  +|', ' ', $string);
        }
        private function replaceSingleTags() {
            //tags that are single (no innerhtml in them)$key = array_keys($aHash);
            if (!$this->ignoreSingleTags)
                $this->level++;
            for ($i=0;$i<$this->nSingleTags;$i++) {
                $this->addTag($i,$this->aSingleTags[0][$i],$this->aSingleTags[1][$i],$this->aSingleTags[2][$i],$this->aSingleTags[0][$i],true);
            }
        }
        private function replaceSimpleTags() {
            //tags that only have text in them (no other content)
            $this->level++;
            for ($i=0;$i<$this->nSimpleTags;$i++) {
                $this->addTag($i,$this->aSimpleTags[0][$i],$this->aSimpleTags[1][$i],$this->aSimpleTags[2][$i],$this->aSimpleTags[3][$i]);
            }
        }
        private function replaceRemainingTags() {
            //tags that remain after everything
            $result=preg_match_all('/<(.[^\s]*)(.[^><]*)?>(.*)?<\/\1>/imU', $this->html, $m);
            if ($result>0) {
                $this->level++;
                for ($i=0;$i<$result;$i++) {
                    $this->addTag($i,$m[0][$i],$m[1][$i],$m[2][$i],$m[3][$i]);
                }
            }
        }
        private function existSimpleTags() {
            $result=preg_match_all('/<(.[^\s]*)(.[^><]*)?>(.[^<]*)?<\/\1>/imU', $this->html, $m);
            $this->aSimpleTags = $m;
            $this->nSimpleTags = $result;
            return $result>0;
        }
        private function existSingleTags() {
            $result=preg_match_all('/<('.$this->singleTags.')(.[^><]*)?>/imU', $this->html, $m);
            $this->aSingleTags = $m;
            $this->nSingleTags = $result;
            return $result>0;
        }
        /**
         * Parses the html and returns an array representing the parsed html
         *
         * @param string $html the html to transform to array (if variable passed when declaring the data type it isn'y needed here)
         * @return array the parsed array
         */
        public function toArray($html='') {
            if ($html!='') {
                $this->html = $this->removeWhiteSpace($html);
            }
            //the only part: coding and we're done :)
            $existSimpleTags = $this->existSimpleTags();
            $existSingleTags = $this->existSingleTags();
            while ($existSimpleTags || $existSingleTags ) {
                if ($existSingleTags) $this->replaceSingleTags();
                if ($existSimpleTags) $this->replaceSimpleTags();

                $existSimpleTags = $this->existSimpleTags();
                $existSingleTags = $this->existSingleTags();
            }
            $this->replaceRemainingTags();

            return $this->idArray;
        }
        /**
         * Loads an html parsed node
         *
         * @param string $rep the replace info
         * @return array an array containing the info of the html parsed node
         */
        public function loadNode($rep) {
            return $this->getElement($rep);
        }
        /**
         * Returns a list of all the tags
         *
         * @return array all parsed tags
         */
        public function getAllTags() {
            return $this->cacheArray;
        }
    }