
<div style="position: relative; width: 45%; float:left;">
<input type="text" 
       id="f-from-{{$name}}"
       value="{{$valueFrom}}" 
       name="filter[{{ $name }}][from]" 
       class="form-control input-small datepicker" >
       
<span class="input-group-addon form-input-icon form-input-filter-icon">
    <i class="fa fa-calendar"></i>
</span>
</div>

<div style="margin: 10px 20px; float:left;"><i class="fa fa-minus"></i></div>

<div style="position: relative; width: 45%; float:left;">
<input type="text" 
       id="f-to-{{$name}}"
       value="{{$valueTo}}" 
       name="filter[{{ $name }}][to]" 
       class="form-control input-small datepicker" >
       
<span class="input-group-addon form-input-icon form-input-filter-icon">
    <i class="fa fa-calendar"></i>
</span>
</div>


<script>
jQuery(document).ready(function() {
    jQuery("#f-from-{{$name}}").datepicker({
        changeMonth: true,
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        dateFormat: "dd/mm/yy",
        //showButtonPanel: true,
        regional: ["ru"],
        onClose: function (selectedDate) {}
    });
    
    jQuery("#f-to-{{$name}}").datepicker({
        changeMonth: true,
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        dateFormat: "dd/mm/yy",
        //showButtonPanel: true,
        regional: ["ru"],
        onClose: function (selectedDate) {}
    });
});
</script>