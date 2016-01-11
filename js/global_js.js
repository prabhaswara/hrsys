(function ($) {

    $.fn.init_js = function (url) {
        $(".required").after("<img class='required-star'  src='" + url + "images/star_red.png' />");

        $(".kendodropdown").kendoDropDownList();
        $(".kendocombo").kendoComboBox();
        $(".kendobutton").kendoButton();
        $(".date").kendoDatePicker({format: "dd-MM-yyyy"});
        $(".date").mask('99-99-9999');
        $(".kendonumber").kendoNumericTextBox({culture: "id-ID",format: "n0"  ,min:0});



    };
     $.fn.setSkillList = function (tx, btn, multiselect,site_url,data_select) {
         if(data_select.length>0){
              $("#"+multiselect).kendoMultiSelect({
                dataTextField: "skill",
                dataValueField: "skill",
                autoBind: false,
                value:data_select,
                open: function(e) {
                  e.sender.ul.css('display', 'none'); 
                  }
            });
         }else{
             $("#"+multiselect).kendoMultiSelect({
                dataTextField: "skill",
                dataValueField: "skill",
                autoBind: false,
                open: function(e) {
                  e.sender.ul.css('display', 'none'); 
                  }
            });
         }
         
        $("#"+tx).kendoComboBox({
                        filter: "contains",
                        dataValueField: "skill",
                        dataTextField: "skill",           
                        dataSource: {
                            serverFiltering: true,
                            transport: {
                                read: {
                                    url: site_url+"/hrsys/skill/searchSkill",
                                }
                            }
                        },
                        change: function(e) {
                                         
                           list_expertise=$("#"+multiselect).data("kendoMultiSelect");                      
                           tx_expertise=$("#"+tx).data("kendoComboBox");
                            var values = list_expertise.value().slice(); 
                            var item=tx_expertise.value();                          
                            if(jQuery.inArray(item,values)!=-1){
                                
                                 tx_expertise.value("");                         
                            }
                        
                         
                        },
                        select: function(e) {
                            
                        skill=e.item.text();                        
                        expertise=$("#"+multiselect).data("kendoMultiSelect");                      
                        
                        var values = expertise.value().slice();                        
                        if(jQuery.inArray(skill,values)==-1){                          
                            expertise.dataSource.add( { skill: skill });
                            $.merge(values, [skill]);                        
                            expertise.value(values);                            
                        }
                        
                      }
                    });
                   // $("#"+tx).data("kendoComboBox").wrapper.find(".k-dropdown-wrap").removeClass("k-dropdown-wrap").addClass("k-autocomplete").find("span").hide();
                    $("#"+tx).data("kendoComboBox").wrapper.find(".k-dropdown-wrap").removeClass("k-dropdown-wrap").find("span").hide();
                    
                
        $("#"+btn).click(function() {
          tx_expertise=$("#"+tx).data("kendoComboBox");
          expertise=$("#"+multiselect).data("kendoMultiSelect");
          if(tx_expertise.value().trim()!=""){
             $.ajax({
                type: "POST",
                data: "skill_name="+tx_expertise.value(),
                url: site_url+"/hrsys/skill/addSkill",
                beforeSend: function (xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (data) {
                   
                    skill=data.skill;

                    expertise=$("#"+multiselect).data("kendoMultiSelect");                      

                    var values = expertise.value().slice();                        
                    if(jQuery.inArray(skill,values)==-1){                          
                        expertise.dataSource.add( { skill: skill });
                        $.merge(values, [skill]);                        
                        expertise.value(values);                            
                    }
                    tx_expertise.value("");
                    $("#ajaxDiv").attr("class", "ajax-hide"); 
                 
                }                
            }); 
          }
           
          
           return false;
        });
     }
    $.fn.gn_popup_submit = function (url, content_id, grid) {
        $.ajax({
            type: "POST",
            url: url,
            data: this.serialize(), // serializes the form's elements.
            beforeSend: function (xhr) {
                $('#' + content_id).html("please wait..");
            },
            success: function (data)
            {

                if (data == "close_popup") {
                    w2popup.close();
                } else {
                    $('#' + content_id).html(data);
                }
				if(grid!=null)
				{
					 grid.reload();
				}
               

            }
        });
    };

    $.fn.gn_submit = function (url) {
        $.ajax({
            type: "POST",
            url: url,
            data: this.serialize(), // serializes the form's elements.
            beforeSend: function (xhr) {
                $("#ajaxDiv").attr("class", "ajax-show");

            },
            success: function (data) {

                w2ui['main_layout'].content('main', data);
                loadingShow(false);
            },
            statusCode: {
                500: function () {
                    loadingShow(false);
                },
                404: function () {
                    loadingShow(false);
                }
            }
        });

        return false;
    };

    $.fn.gn_submit = function (url) {
        $.ajax({
            type: "POST",
            url: url,
            data: this.serialize(), // serializes the form's elements.
            beforeSend: function (xhr) {
                $("#ajaxDiv").attr("class", "ajax-show");

            },
            success: function (data) {

                w2ui['main_layout'].content('main', data);
                loadingShow(false);
            },
            statusCode: {
                500: function () {
                    loadingShow(false);
                },
                404: function () {
                    loadingShow(false);
                }
            }
        });

        return false;
    };

    $.fn.gn_onsubmit = function () {
        $(this).submit(function (event) {
            $.ajax({
                type: "POST",
                data: $(this).serialize(),
                url: $(this).attr("action"),
                beforeSend: function (xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (data) {

                    w2ui['main_layout'].content('main', data);
                    loadingShow(false);
                },
                statusCode: {
                    500: function () {
                        loadingShow(false);
                    },
                    404: function () {
                        loadingShow(false);
                    }
                }
            });
            return false;
        });
    };
    $.fn.gn_onsubmitFile = function () {
        $(this).submit(function (event) {
            $.ajax({
                type: "POST",
                data: new FormData(this),
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                url: $(this).attr("action"),
                beforeSend: function(xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (data) {

                    w2ui['main_layout'].content('main', data);
                    loadingShow(false);
                },
                statusCode: {
                    500: function () {
                        loadingShow(false);
                    },
                    404: function () {
                        loadingShow(false);
                    }
                }
            });
            return false;
        });
    };
    
   
        $.fn.gn_onPopupSubmit = function (divpopup,grid,type) {
        $(this).submit(function (event) {
            $.ajax({
                type: "POST",
                data: $(this).serialize(),
                url: $(this).attr("action"),
                beforeSend: function (xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (data) {

                    if (data == "close_popup") {
                        w2popup.close();
                    } else {
                        $('#'+divpopup).html(data);
                    }
                    loadingShow(false);
                    if(type=="calendar")
					{
						grid.fullCalendar("refetchEvents")
					}
                    else {
						if(grid!=null){
							grid.reload();
						}
                    }   
                },
                statusCode: {
                    500: function () {
                        loadingShow(false);
                    },
                    404: function () {
                        loadingShow(false);
                    }
                }
            });
            return false;

        });


    };
    
     $.fn.gn_onPopupSubmitFile = function (divpopup,grid) {
         
        $(this).submit(function (event) {
             
            $.ajax({
                type: "POST",
                data: new FormData(this),
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false, 
                url: $(this).attr("action"),
                beforeSend: function (xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (data) {

                    if (data == "close_popup") {
                        w2popup.close();
                    } else {
                        $('#'+divpopup).html(data);
                    }
                    loadingShow(false);
                    
                    if(grid!=null)
                         grid.reload();
                },
                statusCode: {
                    500: function () {
                        loadingShow(false);
                    },
                    404: function () {
                        loadingShow(false);
                    }
                }
            });
            return false;

        });


    };
    
  


    $.fn.gn_loadmain = function (url) {

        for (var widget in w2ui) {
            var nm = w2ui[widget].name;
            if (['main_layout', 'sidebar'].indexOf(nm) == -1)
                $().w2destroy(nm);
        }
        loadingShow(true);
        $.ajax({
            type: "POST",
            url: url,
            beforeSend: function (xhr) {

            },
            success: function (data)
            {
                w2ui['main_layout'].content('main', data);
                loadingShow(false);
            },
            statusCode: {
                500: function () {
                    loadingShow(false);
                },
                404: function () {
                    loadingShow(false);
                }
            }

        });
    };


    $.fn.loadingShow = function (status) {
        if (status) {
            $("#ajaxDiv").attr("class", "ajax-show");
        } else {
            $("#ajaxDiv").attr("class", "ajax-hide");
        }
    };

    function loadingShow(status) {

        if (status) {
            $("#ajaxDiv").attr("class", "ajax-show");
        } else {
            $("#ajaxDiv").attr("class", "ajax-hide");
        }
    }


})(jQuery);