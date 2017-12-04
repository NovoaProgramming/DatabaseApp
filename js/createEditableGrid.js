/**
 *  highlightRow and highlight are used to show a visual feedback. If the row has been successfully modified, it will be highlighted in green. Otherwise, in red
 */
function highlightRow(rowId, bgColor, after)
{
	var rowSelector = $("#" + rowId);
	rowSelector.css("background-color", bgColor);
	rowSelector.fadeTo("normal", 0.5, function() { 
		rowSelector.fadeTo("fast", 1, function() { 
			rowSelector.css("background-color", '');
		});
	});
}

function highlight(div_id, style) {
	highlightRow(div_id, style == "error" ? "#e5afaf" : style == "warning" ? "#ffcc00" : "#8dc70a");
}



function message ( type, message) {    
	$('#message').html("<div class=\"notification  "+type+"\">"+message+"</div>").slideDown('normal').delay(1800).slideToggle('slow');
}
        
/**
   updateCellValue calls the PHP script that will update the database. 
 */
function updateCellValue(editableGrid, rowIndex, columnIndex, oldValue, newValue, row, onResponse)
{      
	$.ajax({
		url: 'update.php',
		type: 'POST',
		dataType: "html",
	   		data: {
			tablename : editableGrid.name,
			id: editableGrid.getRowId(rowIndex), 
			newvalue: editableGrid.getColumnType(columnIndex) == "boolean" ? (newValue ? 1 : 0) : newValue, 
			colname: editableGrid.getColumnName(columnIndex),
			coltype: editableGrid.getColumnType(columnIndex)			
		},
		success: function (response) 
		{ 
			// reset old value if failed then highlight row
			var success = onResponse ? onResponse(response) : (response == "ok" || !isNaN(parseInt(response))); // by default, a sucessfull reponse can be "ok" or a database id 
			if (!success) editableGrid.setValueAt(rowIndex, columnIndex, oldValue);
		    highlight(row.id, success ? "ok" : "error"); 
		},
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
	});
   
}
   


function DatabaseGrid(gridName) 
{ 
	this.editableGrid = new EditableGrid(gridName, {
      enableSort: true,


      /* Comment this line if you set serverSide to true */
	    // define the number of row visible by page
      /*pageSize: 50,*/

      /* This property enables the serverSide part */
      serverSide: true,

      // Once the table is displayed, we update the paginator state
        tableRendered:  function() {  updatePaginator(this); },
   	    tableLoaded: function() { datagrid.initializeGrid(this); },
		modelChanged: function(rowIndex, columnIndex, oldValue, newValue, row) {
   	    	updateCellValue(this, rowIndex, columnIndex, oldValue, newValue, row);
       	}
 	});
  this.fetchGrid(gridName); 


  
    $("#filter").val(this.editableGrid.currentFilter != null ? this.editableGrid.currentFilter : "");
	if ( this.editableGrid.currentFilter != null && this.editableGrid.currentFilter.length > 0)
	  $("#filter").addClass('filterdefined');
    else
	  $("#filter").removeClass('filterdefined');
	
}

DatabaseGrid.prototype.fetchGrid = function(tablename)  {
	// call a PHP script to get the data
	this.editableGrid.loadJSON("loaddata.php?db_tablename="+tablename);
};

DatabaseGrid.prototype.initializeGrid = function(grid) {

  var self = this;
  // render for the action column
	grid.setCellRenderer("action", new CellRenderer({ 
		render: function(cell, id) {                 
		      cell.innerHTML+= "<i onclick=\"datagrid.deleteRow("+id+");\" class='fa fa-trash-o red' ></i>";
		}
	})); 


	grid.renderGrid("tablecontent", "testgrid");

};    

DatabaseGrid.prototype.deleteRow = function(id) 
{

  var self = this;

  if ( confirm('Are you sure you want to delete the row id ' + id )  ) {

        $.ajax({
		url: 'delete.php',
		type: 'POST',
		dataType: "html",
		data: {
			tablename : self.editableGrid.name,
			id: id 
		},
		success: function (response) 
		{ 
          if (response == "ok" ) {
              message("success","Row deleted: Refresh table to view changes.");
              self.fetchGrid();
          }
		},
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
	});

        
  }
			
}; 


DatabaseGrid.prototype.addRow = function(id) 
{
	var self = this;
	
	if (self.editableGrid.name == 'employee')
	{
        $.ajax({
		url: 'add.php',
		type: 'POST',
		dataType: "html",
		data: {
			tablename : self.editableGrid.name,
			ReportsTo:  $("#ReportsTo").val(),
			HireDate:  $("#HireDate").val(),
			FirstName:  $("#FirstName").val(),
			LastName:  $("#LastName").val(),
			Title:  $("#Title").val(),
			DateOfBirth:  $("#DateOfBirth").val(),
			JobTitle:  $("#JobTitle").val(),
			Address:  $("#Address").val(),
			City:  $("#City").val(),
			State:  $("#State").val(),
			Zip:  $("#Zip").val(),
			Country:  $("#Country").val(),
			Phone:  $("#Phone").val(),
			Email:  $("#Email").val()
		},
		success: function (response) 
		{ 
			if (response == "ok" ) {
   
                // hide form
                showAddForm();
				$("#ReportsTo").val('');
				$("#HireDate").val('');
				$("#FirstName").val('');
				$("#LastName").val('');
				$("#Title").val('');
				$("#DateOfBirth").val('');
				$("#JobTitle").val('');
				$("#Address").val('');
				$("#City").val('');
				$("#State").val('');
				$("#Zip").val('');
				$("#Country").val('');
				$("#Phone").val('');
				$("#Email").val('');			
				message("success","Row added : Refresh table to view changes.");
				self.fetchGrid();
           	}
            else 
				message("error","Error occured");		
        },
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
		});
	}
    else if (self.editableGrid.name == 'promo')
	{
        $.ajax({
		url: 'add.php',
		type: 'POST',
		dataType: "html",
		data: {
			tablename : self.editableGrid.name,
			PremiumPromotion:  $("#PremiumPromotion").val(),
			Category:  $("#Category").val(),
			Requirements:  $("#Requirements").val(),
			StartDate:  $("#StartDate").val(),
			EndDate:  $("#EndDate").val(),
			Effect:  $("#Effect").val()
		},
		success: function (response) 
		{ 
			if (response == "ok" ) {
                // hide form
                showAddForm();
				$("#PremiumPromotion").val('');
				$("#Category").val('');
				$("#Requirements").val('');
				$("#StartDate").val('');
				$("#EndDate").val('');
				$("#Effect").val('');
				message("success","Row added : Refresh table to view changes.");
				self.fetchGrid();
           	}
            else 
				message("error","Error occured");		
        },
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
		});
	}
	else if (self.editableGrid.name == 'shipment')
	{
        $.ajax({
		url: 'add.php',
		type: 'POST',
		dataType: "html",
		data: {
			tablename : self.editableGrid.name,
			SupplierID:  $("#SupplierID").val(),
			EmployeePlacedOrder:  $("#EmployeePlacedOrder").val(),
			EmployeeReceivedOrder:  $("#EmployeeReceivedOrder").val(),
			OrderStatus:  $("#OrderStatus").val(),
			TrackingNumber:  $("#TrackingNumber").val(),
			ShippedDate:  $("#ShippedDate").val(),
			ExpectedArrivalDate:  $("#ExpectedArrivalDate").val(),
			ActualArrivalDate:  $("#ActualArrivalDate").val(),
			TotalCost:  $("#TotalCost").val(),
			ShippingCost:  $("#ShippingCost").val()			
		},
		success: function (response) 
		{ 
			if (response == "ok" ) {
                // hide form
                showAddForm();
				$("#SupplierID").val('');
				$("#EmployeePlacedOrder").val('');
				$("#EmployeeReceivedOrder").val('');
				$("#OrderStatus").val('');
				$("#TrackingNumber").val('');
				$("#ShippedDate").val('');
				$("#ExpectedArrivalDate").val('');
				$("#ActualArrivalDate").val('');
				$("#TotalCost").val('');
				$("#ShippingCost").val('');
				message("success","Row added : Refresh table to view changes.");
				self.fetchGrid();
           	}
            else 
				message("error","Error occured");		
        },
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
		});
	}
	else if (self.editableGrid.name == 'supplier')
	{
        $.ajax({
		url: 'add.php',
		type: 'POST',
		dataType: "html",
		data: {
			tablename : self.editableGrid.name,
			CompanyName:  $("#CompanyName").val(),
			Address:  $("#Address").val(),
			City:  $("#City").val(),
			State:  $("#State").val(),
			Zip:  $("#Zip").val(),
			Country:  $("#Country").val(),
			Website:  $("#Website").val(),
			ContactFirstName:  $("#ContactFirstName").val(),
			ContactLastName:  $("#ContactLastName").val(),
			ContactTitle:  $("#ContactTitle").val(),
			Phone: $("#Phone").val(),
			Ext:  $("#Ext").val(),
			Email:  $("#Email").val(),
			PreferredMethodOfContact: $("#PreferredMethodOfContact").val()
		},
		success: function (response) 
		{ 
			if (response == "ok" ) {
                // hide form
                showAddForm();
				$("#CompanyName").val('');
				$("#Address").val('');
				$("#City").val('');
				$("#State").val('');
				$("#Zip").val('');
				$("#Country").val('');
				$("#Website").val('');
				$("#ContactFirstName").val('');
				$("#ContactLastName").val('');
				$("#ContactTitle").val('');
				$("#Phone").val('');
				$("#Ext").val('');
				$("#Email").val('');
				$("#PreferredMethodOfContact").val('');
				message("success","Row added : Refresh table to view changes.");
				self.fetchGrid();
           	}
            else 
				message("error","Error occured");		
        },
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
		});
	}	
}; 




function updatePaginator(grid, divId)
{
    divId = divId || "paginator";
	var paginator = $("#" + divId).empty();
	var nbPages = grid.getPageCount();

	// get interval
	var interval = grid.getSlidingPageInterval(20);
	if (interval == null) return;
	
	// get pages in interval (with links except for the current page)
	var pages = grid.getPagesInInterval(interval, function(pageIndex, isCurrent) {
		if (isCurrent) return "<span id='currentpageindex'>" + (pageIndex + 1)  +"</span>";
		return $("<a>").css("cursor", "pointer").html(pageIndex + 1).click(function(event) { grid.setPageIndex(parseInt($(this).html()) - 1); });
	});
		
	// "first" link
	var link = $("<a class='nobg'>").html("<i class='fa fa-fast-backward'></i>");
	if (!grid.canGoBack()) link.css({ opacity : 0.4, filter: "alpha(opacity=40)" });
	else link.css("cursor", "pointer").click(function(event) { grid.firstPage(); });
	paginator.append(link);

	// "prev" link
	link = $("<a class='nobg'>").html("<i class='fa fa-backward'></i>");
	if (!grid.canGoBack()) link.css({ opacity : 0.4, filter: "alpha(opacity=40)" });
	else link.css("cursor", "pointer").click(function(event) { grid.prevPage(); });
	paginator.append(link);

	// pages
	for (p = 0; p < pages.length; p++) paginator.append(pages[p]).append(" ");
	
	// "next" link
	link = $("<a class='nobg'>").html("<i class='fa fa-forward'>");
	if (!grid.canGoForward()) link.css({ opacity : 0.4, filter: "alpha(opacity=40)" });
	else link.css("cursor", "pointer").click(function(event) { grid.nextPage(); });
	paginator.append(link);

	// "last" link
	link = $("<a class='nobg'>").html("<i class='fa fa-fast-forward'>");
	if (!grid.canGoForward()) link.css({ opacity : 0.4, filter: "alpha(opacity=40)" });
	else link.css("cursor", "pointer").click(function(event) { grid.lastPage(); });
	paginator.append(link);
}; 


function showAddForm() {
  if ( $("#addform").is(':visible') ) 
      $("#addform").hide();
  else
      $("#addform").show();
}