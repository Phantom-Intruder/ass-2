<script>
    var User = Backbone.Model.extend({
        schema: {
            firstName:       'Text',
            username:      { validators: ['required'] },
            password:   'Password'
        }
    });

    var user = new User();

    var form = new Backbone.Form({
        model: user
    }).render();

    $('body').append(form.el);
</script>