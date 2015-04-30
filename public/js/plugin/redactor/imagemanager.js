if (!RedactorPlugins) var RedactorPlugins = {};

(function($)
{
    RedactorPlugins.imagemanager = function()
    {
        return {
            init: function()
            {
                if (!this.opts.imageManagerJson) return;

                this.modal.addCallback('image', this.imagemanager.load);
            },
            load: function()
            {
                var $modal = this.modal.getModal();

                this.modal.createTabber($modal);
                this.modal.addTab(1, 'Загрузить', 'active');
                this.modal.addTab(2, 'Выбрать изображение');

                $('#redactor-modal-image-droparea').addClass('redactor-tab redactor-tab1');

                var $box = $('<div id="redactor-image-manager-box" style="overflow: auto; height: 300px;" class="redactor-tab redactor-tab2">').hide();
                $modal.append($box);

                $.ajax({
                  dataType: "json",
                  type: "POST",
                  cache: false,
                  url: this.opts.imageManagerJson,
                  success: $.proxy(function(data)
                    {
                        $.each(data, $.proxy(function(key, val)
                        {
                            var img = $('<img src="'+ val.thumb +'" data-id="'+ val.id +'" title="'+ val.title +'" style="padding: 2px; width: 100px; height: 75px; cursor: pointer;" />');
                            $('#redactor-image-manager-box').append(img);
                            
                            $(img).click($.proxy(this.imagemanager.insert, this));
                        }, this));


                    }, this)
                });


            },
            insert: function(e)
            {
                // <div> for jquery
                var code = '<div>[|image::' + $(e.target).data('id') + '|]</div>';
                this.image.insert(code);
            }
        };
    };
})(jQuery);