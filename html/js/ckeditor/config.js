/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
		config.toolbar_Full =
[
    { name: 'document',    items : ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','Source'] },
   
    { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
       { name: 'tools',       items : [ 'Maximize', 'ShowBlocks' ] },
     { name: 'links',       items : [ 'Link','Unlink', ] },
      { name: 'insert',      items : [ 'Image','Table','HorizontalRule','SpecialChar','PageBreak' ] },
    '/',
    // { name: 'styles',      items : [ 'Styles','Format','Font','FontSize','TextColor' ] },
    { name: 'styles',      items : [ 'Format','Font','FontSize','TextColor' ] },
      { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','-','RemoveFormat' ] },
    { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-' ] }
    

];
	config.height = 300;	
	
};
