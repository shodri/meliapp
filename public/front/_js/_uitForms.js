/*!
 * UITListas v1.0.0 
 * Copyright 2019-2019 UltraIT sa.
 */

if (typeof jQuery === 'undefined') {
  throw new Error('UITListas\'s JavaScript requires jQuery')
}

+function ($) {
  'use strict';
  var version = $.fn.jquery.split(' ')[0].split('.')
  if ((version[0] < 2 && version[1] < 9) || (version[0] == 1 && version[1] == 9 && version[2] < 1) || (version[0] > 3)) {
    throw new Error('UITListas\'s JavaScript requires jQuery version 1.9.1 or higher, but lower than version 4')
  }
}(jQuery);

+function ($) {
	'use strict';
	var imgSpacer;

	function submitListForm(cmd, par) {
		$("input[name=cmd]").val(cmd);
		$('input[name=par]').val(par);
		//console.log(cmd + ':' + par);
		//console.log( $('#myform') );
		$('#myform').submit();
	}
  
	var newRecord = function(e){
		if (e) e.preventDefault();
		submitListForm('edit','');
	}
	
	var editRecord = function(e){
		//console.log('editRecord');
		if (e) e.preventDefault();
		var id=$( e.target ).closest( "tr" ).attr( "data-id" );
		//console.log(id);
		submitListForm('edit',id);
	}
	
	var deleteRecord = function(e){
		//console.log('deleteRecord');
		if (e) e.preventDefault();
		if (confirm('¿Está seguro que desea borrar el registro seleccionado?')) {
			var id=$( e.target ).closest( "tr" ).attr( "data-id" );
			submitListForm('del',id);
		}
	}
	
	var sortRecords = function(e){
		if (e) e.preventDefault();
		var oField = $( this ).attr( "data-field" );
		if($('input[name=oField]').val() == oField) {
			if($('input[name=oDir]').val() == 'asc') 
				$('input[name=oDir]').val('desc');
			else
				$('input[name=oDir]').val('asc');
		} else {
			$('input[name=oField]').val(oField);
			$('input[name=oDir]').val('asc');
		}	
		submitListForm('','');
	}

  $(window).on('load', function () {
	$(' .btn-newRecord ').on('click', newRecord);
	
	if($(' table.dataTable ').length) {
		// Eventos por datatTable
		$(' table.dataTable tbody ').on('click', 'tr td .btn-editRecord', editRecord);
		$(' table.dataTable tbody ').on('click', 'tr td .btn-deleteRecord', deleteRecord);
		$(' table.dataTable tbody ').on('click', 'tr td .btn-sortRecords', sortRecords);
	} else {
		// Eventos por table
		$(' .btn-editRecord ').on('click', editRecord);
		$(' .btn-deleteRecord ').on('click', deleteRecord);
		$(' .btn-sortRecords ').on('click', sortRecords);
	}	
  })

}(jQuery);
