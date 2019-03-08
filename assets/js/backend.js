/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    setupImageGallery();
    setupPageGallery();
    setupContentGallery();
    setupUsersManager();
    setupOrderedLists();

    $('select[name="language"]').change(function (e) {
        $(this).parents('form').submit();
    });

    $(document).on('change', '#page-page_type_id', function(e){
        console.log($(this));
        $(this).parents('form').submit();
    })


});

function setupOrderedLists() {
    let list = $('.list-view > ol');
    list.sortable({
        handle: '.handle',
        onUpdate: function (evt) {
            let id = $(evt.item).attr('id');
            let index = evt.newIndex;
            let position = index + 1;
            let baseurl = list.data('update-page');
            $.post(baseurl, {
                id: id,
                position: position,
            }).done(function (data) {
                console.log('hecho', data);
            });
        }
    });
}

function setupUsersManager() {

    $(document).on('dblclick', '#website-notassignedusers, #website-users', function (e) {
        var action = $(this).data('action');
        var params = $(this).data('params');
        params.user_id = $(this).val();

        var $currentListBox = $(this);
        var $otherListBox = $($(this).data('other'));

        $.ajax({
            type: "POST",
            url: action,
            data: params,
            success: function (data, textStatus, jqXHR) {
                if (data.success == true) {
                    var optionSelector = ("#" + $currentListBox.attr('id') + ' > option[value={value}]').replace('{value}', params.user_id);
                    var $option = $(optionSelector).detach();

                    if ($otherListBox.attr('id') == 'circuit-notassignedusers') {
                        //insert in the correct position alphabetically
                        var inserted = false;
                        $($otherListBox.children()).each(function (index, item) {
                            if (!inserted && $option.text() < $(item).text()) {
                                $(item).before($option);
                                inserted = true;
                            }
                        });
                        if (!inserted) {
                            $otherListBox.append($option);
                        }
                    } else {
                        $otherListBox.append($option);
                    }

                }
            },
            dataType: 'json'
        });

    });

}

function setupContentGallery() {
    $(document).on('click', '#select-content-modal li > a', function (e) {
        e.preventDefault();
        $($('#select-content-modal').data('target-field')).val($(this).attr('href'));
        $($('#select-content-modal').data('label-field')).val($(this).text());
        $('#select-content-modal').modal('hide');
    });
}

function setupImageGallery() {
    $(document).on('change', $('#image-gallery-modal').data('target-field'), function (e) {
        $($('#image-gallery-modal').data('preview')).attr('src', $(this).val());
    });

    $(document).on('click', '#image-gallery-modal img', function (e) {
        $($('#image-gallery-modal').data('target-field')).val($(this).data('url'));
        $('#image-gallery-modal').modal('hide');
        $($('#image-gallery-modal').data('target-field')).trigger('change');
    });

    $(document).on('click', '#btn-remove-picture', function (e) {
        $($('#image-gallery-modal').data('preview')).attr('src', $('#image-gallery-modal').data('default-image'));
        $($('#image-gallery-modal').data('target-field')).val('');
    });
}

function setupPageGallery() {

    var $gallery = $('#page-gallery-modal');

    $(document).on('click', '#page-gallery-modal img', function (e) {
        console.log([
            $(this),
            $(this).data('id'),
        ]);
        var url = $gallery.data('url').replace('image_id_param', $(this).data('id'));
        $.post(url, function () {
            $('#page-gallery-modal').modal('hide');
        });
    });
}
