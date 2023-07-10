<?php
/*
 * @package   plg_radicalmart_media_file
 * @version   __DEPLOY_VERSION__
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2023 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Utilities\ArrayHelper;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string $selector Current field selector.
 * @var   string $name     Name of the input field.
 * @var   array  $value    Value attribute of the field.
 * @var   bool   $template Is template.
 *
 */

if ($template)
{
	return LayoutHelper::render('plugins.radicalmart_media.file.field.gallery.template', $displayData);
}

if (empty($value['src']))
{
	return;
}

$fields = [
	[
		'type'  => 'hidden',
		'name'  => $name . '[type]',
		'value' => $value['type'],
	],
	[
		'type'  => 'text',
		'name'  => $name . '[src]',
		'readonly' => true,
		'value' => $value['src'],
		'class' => 'w-100 form-control border rounded-0 border-bottom-0'
	],
	[
		'type'        => 'text',
		'name'        => $name . '[text]',
		'value'       => $value['text'],
		'placeholder' => Text::_('PLG_RADICALMART_MEDIA_FILE_TEXT_PLACEHOLDER'),
		'class'       => 'w-100 form-control border rounded-0 border-bottom-0',
	]
]
?>
<div class="col col-md-6 col-lg-3 mb-3" radicalmart-field-gallery="item"
     data-selector="<?php echo $selector; ?>">
    <div class="card">
        <div class="card-text">
			<?php foreach ($fields as $attributes)
			{
				echo '<input ' . ArrayHelper::toString($attributes) . '>';
			} ?>
        </div>
        <div class="btn-group">
            <a class="btn btn-sm btn-success hasTooltip" radicalmart-field-gallery="add"
               title="<?php echo Text::_('COM_RADICALMART_GALLERY_ACTION_ADD'); ?>">
                <span class="icon-plus"></span>
            </a>
            <a class="btn btn-sm btn-danger hasTooltip" radicalmart-field-gallery="remove"
               title="<?php echo Text::_('COM_RADICALMART_GALLERY_ACTION_REMOVE'); ?>">
                <span class="icon-minus"></span>
            </a>
            <span class="btn btn-sm btn-primary hasTooltip" radicalmart-field-gallery="move"
                  title="<?php echo Text::_('COM_RADICALMART_GALLERY_ACTION_MOVE'); ?>">
				<span class="icon-arrows-alt"></span>
			</span>
        </div>
    </div>
</div>