<?php
/*
 * @package   plg_radicalmart_media_file
 * @version   __DEPLOY_VERSION__
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2023 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

namespace Joomla\Plugin\RadicalMartMedia\File\Extension;

\defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\DispatcherInterface;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;

class File extends CMSPlugin implements SubscriberInterface
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    bool
	 *
	 * @since  1.0.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * Loads the application object.
	 *
	 * @var  \Joomla\CMS\Application\CMSApplication
	 *
	 * @since  1.0.0
	 */
	protected $app = null;

	/**
	 * Loads the database object.
	 *
	 * @var  \Joomla\Database\DatabaseDriver
	 *
	 * @since  1.0.0
	 */
	protected $db = null;

	/**
	 * Constructor
	 *
	 * @param   DispatcherInterface  &$subject  The object to observe
	 * @param   array                 $config   An optional associative array of configuration settings.
	 *                                          Recognized key values include 'name', 'group', 'params', 'language'
	 *                                          (this list is not meant to be comprehensive).
	 *
	 * @since   1.0.0
	 */
	public function __construct(&$subject, $config = array())
	{
		parent::__construct($subject, $config);

		Factory::getApplication()->getLanguage()->load('plg_radicalmart_media_file', JPATH_ADMINISTRATOR);
	}

	/**
	 * Returns an array of events this subscriber will listen to.
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			'onRadicalMartGetGalleryFieldTypes'   => 'onRadicalMartGetGalleryFieldTypes',
			'onRadicalMartGetProductGalleryTypes' => 'onRadicalMartGetProductGalleryTypes'
		];
	}

	/**
	 * Method to change field types.
	 *
	 * @param   string             $context  Context
	 * @param   array              $types    Types
	 * @param   \SimpleXMLElement  $element  element
	 *
	 * @throws  \Exception
	 *
	 * @since  1.0.0
	 */
	public function onRadicalMartGetGalleryFieldTypes($context, &$types, $element)
	{
		if (isset($types['file']))
		{
			return;
		}

		$file = [
			'type'                => 'file',
			'title'               => Text::_('PLG_RADICALMART_MEDIA_FILE_TYPE'),
			'icon'                => 'icon-file',
			'layout_item'         => 'plugins.radicalmart_media.file.field.gallery.item',
			'layout_template'     => 'plugins.radicalmart_media.file.field.gallery.template',
			'assets_extension'    => 'plg_radicalmart_media_file',
			'assets_script'       => 'plg_radicalmart_media_file.fields.gallery.file',
			'modal_url'           => 'index.php?option=com_media&view=media&tmpl=component',
			'modal_button_select' => 'window.RadicalMartFieldGalleryFile.select(this)',
		];

		if (ComponentHelper::isEnabled('com_quantummanager'))
		{
			$file['title']               = Text::_('PLG_RADICALMART_MEDIA_FILE_TYPE');
			$file['icon']                = 'icon-file';
			$file['assets_script']       = 'plg_radicalmart_media_file.fields.gallery.file-quantum';
			$file['modal_url']           = 'index.php?option=com_quantummanager&tmpl=component&layout=window';
			$file['modal_button_select'] = 'window.RadicalMartFieldGalleryFileQuantum.select(this)';
		}

		$types['file'] = $file;
	}

	/**
	 * Method to get product gallery types layouts.
	 *
	 * @param   string     $context   Context
	 * @param   array      $types     Types
	 * @param   \stdClass  $product   Product object
	 * @param   \stdClass  $category  Category object
	 *
	 * @throws  \Exception
	 *
	 * @since  1.0.0
	 */
	public function onRadicalMartGetProductGalleryTypes($context, &$types, $product, $category)
	{
		if (isset($types['file']))
		{
			return;
		}

		$types['file'] = [];
	}
}