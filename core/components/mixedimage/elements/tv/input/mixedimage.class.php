<?php
if(!class_exists('MixedImageInputRender')) {
	class MixedImageInputRender extends modTemplateVarInputRender {

		public function getTemplate() {
			return $this->modx->getOption('core_path').'components/mixedimage/elements/tv/input/tpl/mixedimage.tpl';
		}

		public function process($value,array $params = array()) {
			$this->modx->regClientCSS($this->modx->getOption('assets_url').'components/mixedimage/css/mgr/mixedimage.css');
			$this->modx->regClientStartupScript($this->modx->getOption('assets_url').'components/mixedimage/js/mgr/mixedimage.js');
			// Set assets path
			$this->setPlaceholder('assets',$this->modx->getOption('assets_url').'components/mixedimage/');

			$this->modx->lexicon->load('mixedimage');

			$this->setPlaceholder('res_id',$this->modx->resource->get('id'));
			$this->setPlaceholder('ms_id',$this->tv->source);
			$this->setPlaceholder('jsonlex',json_encode($this->modx->lexicon->fetch('mixedimage.',true)));
			$this->setPlaceholder('lex',(object)$this->modx->lexicon->fetch('mixedimage.',true));

			// Resource Alias
			$resource_alias = ($this->modx->resource->get('alias')) ? $this->modx->resource->get('alias') : '';
			$this->setPlaceholder('res_alias', $resource_alias);

			// Parent ID
			$parent = $this->modx->resource->getOne('Parent');
			$parent_id = ($parent) ? $parent->get('id') : 0;
			$this->setPlaceholder('p_id', $parent_id);

			// Parent Alias
			$parent_alias = ($parent) ? $parent->get('alias') : '';
			$this->setPlaceholder('p_alias', $parent_alias);

			// Longwinded method to get tv_id to work with MIGX
			#$this->setPlaceholder('tv_id',$this->tv->get('id'));
			$rootTv = $this->modx->getObject('modTemplateVar',array(
				'name' => $this->tv->get('name')
			));
			$this->setPlaceholder('tv_id',$rootTv->get('id'));

			$opts = unserialize($rootTv->input_properties);
			$this->setPlaceholder('prefixFilename', ($opts['prefixFilename']==$this->modx->lexicon('yes') ? 'true' : 'false'));
			$this->setPlaceholder('showPreview', ($opts['showPreview']==$this->modx->lexicon('yes') ? 'true' : 'false'));
			$this->setPlaceholder('showValue', ($opts['showValue']==$this->modx->lexicon('yes') ? 'true' : 'false'));

			$tv = $this->tv;

			if(isset($params['MIME'])){
				$MIME = $params['MIME'];
			} else {
				$MIME = '';
			};
			$this->setPlaceholder('MIME_TYPES',json_encode($MIME));
		}

		public function getLexiconTopics(){
			return array('mixedimage:default');
		}

	}
}
return 'MixedImageInputRender';