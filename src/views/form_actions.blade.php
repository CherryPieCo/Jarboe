<div class="form-actions">
@if ($is_blank)
    <button type="button" onclick="TableBuilder.saveInsertForm()" class="btn btn-primary btn-small">Save</button> or 
    <a class="text-danger" onclick="TableBuilder.closeEditForm()" href="#">Cancel</a>
@else
    <button type="button" onclick="TableBuilder.saveEditForm()" class="btn btn-primary btn-small">Save</button> or 
    <a class="text-danger" onclick="TableBuilder.closeEditForm()" href="#">Cancel</a>
@endif
</div>