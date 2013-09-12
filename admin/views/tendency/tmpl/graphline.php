<?php
/**
 * @module		com_totalsurv
 * @author-name Manuel L. Lara
 * @adapted by  Manuel L.Lara
 * @copyright	Copyright (C) 2012 Manuel L. Lara
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<div class="page-print">
	<h3 class="k-title"><?php echo $this->title; ?></h3>
	<h4 class="k-subtitle"><?php echo $this->subtitle; ?></h4>
	<div id="render-graph"></div>
	<br>
	<div class="k-center"><button class="k-button" onclick="javascript:print();"><?php echo JText::_('COM_TOTALSURV_LABEL_PRINT'); ?></button></div>
	<script type="text/javascript" src="<?php echo URL_FOLDER_ADMIN.'/views/tendency/tmpl/graphtendency.js'; ?>"></script>
</div>