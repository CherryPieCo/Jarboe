
<input type="text" 
       id="{{$name}}"
       value="{{$value}}" 
       name="{{$name}}" 
       class="form-control datepicker" >
       
<span class="input-group-addon form-input-icon">
	<i class="fa fa-calendar"></i>
</span>

<script>
jQuery(document).ready(function() {
    jQuery("#{{$name}}").datepicker({
        changeMonth: true,
        numberOfMonths: {{ $months ? : '1' }},
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        dateFormat: "dd/mm/yy",
        //showButtonPanel: true,
        regional: ["ru"],
        onClose: function (selectedDate) {}
    });
});
</script>