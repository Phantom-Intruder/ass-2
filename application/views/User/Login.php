<script id="loginForm" type="text/html">
    <form action="LoginSubmit.html" method="post">
        <h3>Login</h3>

        <h5>Your Login details:</h5>
        <div data-fields="username,password"></div>

        <input type="submit" class="btn btn-info submit" />
    </form>
</script>

<script>
    $(function() {
        //Extend Backbone.Form and customise, set schema
        var LoginForm = Backbone.Form.extend({

            template: _.template($('#loginForm').html()),

            schema: {
                username: {
                    validators: ['required']
                },
                password: {
                    type: 'Password',
                    validators: ['required']
                },
            }

        });

        //Create the form instance and add to the page
        var form = new LoginForm().render();

        $('body').append(form.el);

        //Run validation before submitting
        form.on('submit', function(event) {
            var errs = form.validate();

            if (errs) event.preventDefault();
        });

    });
</script>