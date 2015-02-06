<div class="modal fade" id="tree-create-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                ×
            </button>
            <h4 class="modal-title" id="myModalLabel">Создать ноду</h4>
        </div>
        <div class="modal-body">
            <form id="tree-create-modal-form">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" name="title" id="cf-title" class="form-control" placeholder="Название" required="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cf-template">Шаблон</label>
                        <select class="form-control" id="cf-template" name="template">
                            <option value="">Выберите шаблон</option>
                            <?php /* FIXME: */ $tpls = \Config::get('table-builder::tree.templates', array()); ?>
                            @foreach ($tpls as $capt => $tpl)
                                <option value="{{{ $capt }}}">{{{ $capt }}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tags">Слаг</label>
                        <input type="text" name="slug" class="form-control" id="cf-slug" placeholder="slug">
                    </div>
                </div>
            </div>
            <input type="hidden" name="node" id="cf-node" value="" />
            </form>
        </div>
        <div class="modal-footer">
            <a onclick="Tree.doCreateNode();" href="javascript:void(0);" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-floppy-disk"></span> Сохранить
            </a>
            <a href="javascript:void(0);" class="btn btn-default" data-dismiss="modal">
                Отмена
            </a>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>