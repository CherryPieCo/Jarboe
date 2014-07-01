<form id="{{ $def['options']['table_ident'] }}" 
      action="{{ $def['options']['action_url'] }}" 
      method="post" 
      class="form-horizontal tb-table"
      target="submiter" >

<table class="table table-bordered table-striped table-hover">

    <thead>
        @include('tb::table_thead')
    </thead>

    <tbody>
        @include('tb::table_tbody')
    </tbody>

</table> 

@include('tb::table_pagination')

</form>    