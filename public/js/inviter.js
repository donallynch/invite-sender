let inviter = {
    markers: {},
    modal: null,
    renderer: null,
    token: null,
    init: function () {
        inviter.modal = $("#general-modal");
        inviter.renderer = $("#renderer");
        inviter.token = $('#_token').val();
        inviter.registerEvents();
    },
    registerEvents: function () {
        $(document).ready(function(){
            $(document).on("click", "#perform-upload", function () {
                inviter.modal.modal('hide');
                let filePicker = $(this).closest('form').find('#upload-json'),
                    file = filePicker.prop('files')[0],
                    reader = new FileReader();
                reader.onload = function(e) {
                    inviter.readInvitations(this);
                    inviter.post();
                };
                reader.readAsText(file);
            });

            $(document).on("click", "#get-json", function () {
                inviter.modal.modal('show');
            });
        });
    },
    readInvitations: function (_this) {
        var lines = _this.result.split('\n');
        for (var l = 0; l < lines.length; l++) {
            let json = JSON.parse(lines[l]);
            inviter.markers[l] = {};
            inviter.markers[l]['lat'] = json.latitude;
            inviter.markers[l]['lng'] = json.longitude;
            inviter.markers[l]['name'] = json.name;
            inviter.markers[l]['user_id'] = json.user_id;
        }
    },
    post: function () {
        $.post("/invite", {markers: inviter.markers, _token: inviter.token})
            .done(function(response) {
                let status = parseInt(response.status);
                if (response.status !== 200) {
                    console.log(status);
                    console.log(response);
                }
                inviter.renderer.html(response.html);
            });
    }
};
inviter.init();