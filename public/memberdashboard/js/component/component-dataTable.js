/*! For license information please see component-dataTable.js.LICENSE.txt */
"use strict";function lastvisibletd(){$(".table tbody tr td").removeClass("lastvisible"),$(".table tbody tr").each((function(){$(this).find("td:visible:last").addClass("lastvisible")}))}document.addEventListener("DOMContentLoaded",(function(){lastvisibletd()})),document.addEventListener("window.resize",(function(){alert(),$("#datatable").DataTable().columns.adjust().draw(),lastvisibletd()}));