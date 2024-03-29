<?php
/**
 * @version     $Id$
 * @package     JSNTPLFW
 * @author      JoomlaShine Team <support@joomlashine.com>
 * @copyright   Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<div class="control-group">
	<div class="control-label">
		<label for="<?php echo "{$this->id}_style"; ?>" rel="tipsy" original-title="<?php echo JText::_('JSN_TPLFW_FONT_STYLE_DESC'); ?>"><?php echo JText::_('JSN_TPLFW_FONT_STYLE'); ?></label>
	</div>
	<div class="controls">
		<select id="<?php echo "{$this->id}_style"; ?>" name="<?php echo $this->name ?>[style]" autocomplete="off" <?php echo $this->disabled ? 'disabled="disabled"' : ''; ?>>
			<?php foreach ($this->options AS $style => $data) : ?>
			<option value="<?php echo $style; ?>"<?php echo $this->value['style'] == $style ? ' selected' : ''; ?>>
				<?php echo JText::_($data['label']); ?>
			</option>
			<?php endforeach; ?>
		</select>
	</div>
</div>

<script type="text/javascript">
	(function($) {
		$(document).ready(function() {
			new $.JSNFontCustomizer({
				id: '<?php echo $this->id; ?>',
				sections: ['<?php echo implode("', '", $this->sections); ?>'],
				template: '%TEMPLATE%',
				lang: {
					JSN_TPLFW_FONT_FILE_SELECT: '<?php echo JText::_('JSN_TPLFW_FONT_FILE_SELECT'); ?>',
					JSN_TPLFW_FONT_FILE_UPLOADING: '<?php echo JText::_('JSN_TPLFW_FONT_FILE_UPLOADING'); ?>',
					JSN_TPLFW_FONT_FILE_NOT_SUPPORTED: '<?php echo JText::_('JSN_TPLFW_FONT_FILE_NOT_SUPPORTED'); ?>'
				}
			});
		});

		// Override submit button function
		$.JSNFontCustomizer.JSubmitButton = Joomla.submitbutton;

		Joomla.submitbutton = function(task)
		{
			// Remove all font uploader forms
			<?php if (in_array('embed', $this->types)) : ?>$('form.jsn-font-uploader').remove();<?php endif; ?>

			// Clean-up elements generated by Chosen for selection
			$('ul.chzn-results').remove();

			// Shorten standard font family / Google font face select box
			$('select.jsn-font-select-box option').each(function(i, e) {
				e.selected || $(e).remove();
			});

			// Trigger submit button function
			typeof $.JSNFontCustomizer.JSubmitButton == 'undefined' || $.JSNFontCustomizer.JSubmitButton(task);
		};
	})(jQuery);
</script>

<?php
if ($this->disabled)
{
	return;
}

foreach ($this->options AS $style => $data) :
	if ($data['customizable']) : ?>
<div class="jsn-font-customizer<?php echo $this->value['style'] == $style ? '' : ' hide'; ?>" id="<?php echo "{$this->id}_style_{$style}"; ?>">
	<?php foreach ($this->sections AS $section) : ?>
	<h3><?php echo JText::_('JSN_TPLFW_FONT_' . strtoupper($section) . '_LABEL'); ?></h3>

	<div class="control-group">
		<div class="control-label">
			<label for="<?php echo "{$this->id}_{$style}_{$section}_type"; ?>" rel="tipsy" original-title="<?php echo JText::_('JSN_TPLFW_FONT_TYLE_DESC'); ?>"><?php echo JText::_('JSN_TPLFW_FONT_TYLE'); ?></label>
		</div>
		<div class="controls">
			<select id="<?php echo "{$this->id}_{$style}_{$section}_type"; ?>" name="<?php echo $this->name ?>[<?php echo $style; ?>][<?php echo $section; ?>][type]" autocomplete="off">
				<?php foreach ($this->types AS $type) : ?>
				<option value="<?php echo $type; ?>"<?php echo @$this->value[$style][$section]['type'] == $type ? ' selected' : ''; ?>>
					<?php echo JText::_('JSN_TPLFW_FONT_TYLE_' . strtoupper($type)); ?>
				</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<?php foreach ($this->types AS $type) : ?>
	<?php if ($type == 'standard') : ?>
	<div id="<?php echo "{$this->id}_{$style}_{$section}_type_standard"; ?>"<?php echo ( ! @$this->value[$style][$section]['type'] || @$this->value[$style][$section]['type'] == 'standard') ? '' : ' class="hide"'?>>
		<div class="control-group">
			<div class="control-label">
				<label for="<?php echo "{$this->id}_{$style}_{$section}_family"; ?>" rel="tipsy" original-title="<?php echo JText::_('JSN_TPLFW_FONT_FAMILY_DESC'); ?>"><?php echo JText::_('JSN_TPLFW_FONT_FAMILY'); ?></label>
			</div>
			<div class="controls">
				<select class="jsn-font-select-box jsn-list-standard-font-family" id="<?php echo "{$this->id}_{$style}_{$section}_family"; ?>" name="<?php echo $this->name ?>[<?php echo $style; ?>][<?php echo $section; ?>][family]">
					<?php foreach ($this->standard AS $family) : $shorten = trim(substr($family, 0, strpos($family, ',')), "'"); ?>
					<option class="jsn-list-item-standard-font-family-<?php echo str_replace(' ', '-', strtolower($shorten)); ?>" value="<?php echo $family; ?>"<?php echo @$this->value[$style][$section]['family'] == $family ? ' selected' : ''; ?>>
						<?php echo $shorten; ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>

	<?php elseif ($type == 'google') : ?>
	<div id="<?php echo "{$this->id}_{$style}_{$section}_type_google"; ?>"<?php echo @$this->value[$style][$section]['type'] == 'google' ? '' : ' class="hide"'?>>
		<div class="control-group">
			<div class="control-label">
				<label for="<?php echo "{$this->id}_{$style}_{$section}_primary"; ?>" rel="tipsy" original-title="<?php echo JText::_('JSN_TPLFW_FONT_PRIMARY_DESC'); ?>"><?php echo JText::_('JSN_TPLFW_FONT_PRIMARY'); ?></label>
			</div>
			<div class="controls">
				<select class="jsn-font-select-box jsn-list-google-font-face" data-placeholder="<?php echo JText::_('JSN_TPLFW_FONT_PRIMARY_SELECT'); ?>" id="<?php echo "{$this->id}_{$style}_{$section}_primary"; ?>" name="<?php echo $this->name ?>[<?php echo $style; ?>][<?php echo $section; ?>][primary]">
					<?php foreach ($this->google AS $face) : ?>
					<option class="jsn-list-item-google-font-face-<?php echo str_replace(' ', '-', strtolower($face)); ?>" value="<?php echo $face; ?>"<?php echo @$this->value[$style][$section]['primary'] == $face ? ' selected' : ''; ?>>
						<?php echo $face; ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<div class="control-label">
				<label for="<?php echo "{$this->id}_{$style}_{$section}_secondary"; ?>" rel="tipsy" original-title="<?php echo JText::_('JSN_TPLFW_FONT_SECONDARY_DESC'); ?>"><?php echo JText::_('JSN_TPLFW_FONT_SECONDARY'); ?></label>
			</div>
			<div class="controls">
				<select class="jsn-font-select-box jsn-list-standard-font-family" id="<?php echo "{$this->id}_{$style}_{$section}_secondary"; ?>" name="<?php echo $this->name ?>[<?php echo $style; ?>][<?php echo $section; ?>][secondary]">
					<?php foreach ($this->standard AS $family) : $shorten = trim(substr($family, 0, strpos($family, ',')), "'"); ?>
					<option class="jsn-list-item-standard-font-family-<?php echo str_replace(' ', '-', strtolower($shorten)); ?>" value="<?php echo $family; ?>"<?php echo @$this->value[$style][$section]['secondary'] == $family ? ' selected' : ''; ?>>
						<?php echo $shorten; ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>

	<?php elseif ($type == 'embed') : ?>
	<div id="<?php echo "{$this->id}_{$style}_{$section}_type_embed"; ?>"<?php echo @$this->value[$style][$section]['type'] == 'embed' ? '' : ' class="hide"'?>>
		<div class="control-group">
			<div class="control-label">
				<label for="<?php echo "{$this->id}_{$style}_{$section}_file"; ?>" rel="tipsy" original-title="<?php echo JText::_('JSN_TPLFW_FONT_FILE_DESC'); ?>"><?php echo JText::_('JSN_TPLFW_FONT_FILE'); ?></label>
			</div>
			<div class="controls">
				<input id="<?php echo "{$this->id}_{$style}_{$section}_file"; ?>" name="<?php echo $this->name ?>[<?php echo $style; ?>][<?php echo $section; ?>][file]" type="hidden" value="<?php echo @$this->value[$style][$section]['file']; ?>" />
				<p id="<?php echo "{$this->id}_{$style}_{$section}_file_upload_status"; ?>"<?php echo @$this->value[$style][$section]['file'] ? '' : ' class="hide"'?>>
					<span class="label label-success"><?php echo @$this->value[$style][$section]['file']; ?></span>
					<i class="jsn-icon16 jsn-icon-loading hide"></i>
				</p>
				<form action="index.php?widget=font&action=upload" class="jsn-font-uploader" method="POST" enctype="multipart/form-data" onsubmit="return false;">
					<input class="input-mini" id="<?php echo "{$this->id}_{$style}_{$section}_file_upload"; ?>" name="font-upload" type="file" />
					<button class="btn"><?php echo JText::_('JSN_TPLFW_FONT_FILE_UPLOAD'); ?></button>
				</form>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php endforeach; ?>
	<?php endforeach; ?>

	<div class="control-group">
		<div class="control-label">
			<label for="<?php echo "{$this->id}_{$style}_size"; ?>" rel="tipsy" original-title="<?php echo JText::_('JSN_TPLFW_FONT_SIZE_DESC'); ?>"><?php echo JText::_('JSN_TPLFW_FONT_SIZE'); ?></label>
		</div>
		<div class="controls">
			<div class="input-append">
				<input class="input-mini validate-positive-number" id="<?php echo "{$this->id}_{$style}_size"; ?>" name="<?php echo $this->name ?>[<?php echo $style; ?>][size]" type="number" value="<?php echo (int) @$this->value[$style]['size']; ?>" />
				<span class="add-on">%</span>
			</div>
		</div>
	</div>
</div>
<?php
	endif;
endforeach;
?>
