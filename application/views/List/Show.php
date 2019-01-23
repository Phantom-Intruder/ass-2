<h3 class="panel-title">Items List</h3>

<div id="object-list" class="panel-body"></div>

<script>
    var Item = Backbone.Model.extend({
        url: "<?= base_url().'index.php/Home/Item'; ?>",
        schema : {
            title: {
                type: 'Text',
                validators: ['required']
            },
            url: {
                type: 'Text',
                validators: ['required']
            },
            price: {
                type: 'Number',
                validators: ['required', 'number']
            },
            priority: {
                type: 'Select',
                options: ['Must Have', 'Would Be Nice To Have', 'If You Can']
            }
        },
        defaults: {
          id: ""
        },
        toString: function() {
            var attrs = this.attributes;
            return '<div class="container">' +
                        '<div class="row">' +
                            '<div class="col-sm">'
                            + attrs.title +
                            ',</div>' +
                            '<div class="col-sm">'
                            + attrs.url +
                            ',</div>' +
                            '<div class="col-sm">'
                            + attrs.price+
                            ',</div>' +
                            '<div class="col-sm">'
                            + attrs.priority+
                            '</div>' +
                        '</div>' +
                    '</div>';
        }
    });

    var Items = Backbone.Model.extend({
        url: "<?= base_url().'index.php/Home/Items'; ?>",
        defaults : {
            item: {}
        }
    });

    var WishList = Backbone.Model.extend({
        schema: {
            items: {
                type: 'List',
                itemType: 'NestedModel',
                model: Item
            }
        }
    });

    var arrayOfItems = [];
    var mustHaves = [];
    var wouldLike = [];
    var ifCar = [];

    var items = new Items();
    var form;

    items.fetch({
        success: function () {
            for (var i = 0; i < 100; i++){
                if (items.get(''+i+'') !== undefined){
                    console.log(items.get(''+i+''));
                    if (items.get(''+i+'').priority === 'Must Have'){
                        mustHaves.push(items.get(''+i+''));
                    }else if (items.get(''+i+'').priority === 'Would Be Nice To Have'){
                        wouldLike.push(items.get(''+i+''));
                    }else{
                        ifCar.push(items.get(''+i+''));
                    }
                }
            }
            arrayOfItems = mustHaves.concat(wouldLike).concat(ifCar);
            var wishListModel = new WishList({
                items: arrayOfItems
            });

            Backbone.Form.editors.List.Modal.ModalAdapter = Backbone.BootstrapModal;

            form = new Backbone.Form({
                model: wishListModel,
                validate: true
            }).render();

            $('.panel-body').html(form.el);

            var listEditor = form.fields['items'].editor;

            listEditor.on('add', function(form, itemEditor) {
                var addedItem = new Item();
                var title = itemEditor.getValue().title;
                var url = itemEditor.getValue().url;
                var price = itemEditor.getValue().price;
                var priority = itemEditor.getValue().priority;
                addedItem.set({title: title, url: url, price: price, priority: priority});
                //console.log(addedItems);
                addedItem.save({
                    success: function (response) {

                    }
                });
            });

            listEditor.on('remove', function(form, itemEditor) {
                var removedItem = new Item();

                var id = itemEditor.getValue().id;
                removedItem.url = removedItem.url + '/' + id;
                console.log(removedItem);

                removedItem.destroy();
            });
        }
    });
</script>