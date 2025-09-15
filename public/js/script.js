$(function () {
    const $form = $('#search-form');
    const $tbody = $('#list-body');
    const $pager = $('#paginator');

    function fetchList(params) {
        $.get(window.routes.searchProducts, params)
            .done(function (res) {
                $('#list-body').html(res.rows);
                $('#paginator').html(res.pager);
            })
            .fail(function (xhr) {
                alert('検索に失敗しました。');
            });
    }


    // 検索（送信を止めて Ajax）
    $form.on('submit', function (e) {
        e.preventDefault();
        fetchList($form.serialize());
    });

    // ヘッダクリックでソート sort/dir を切替えて再取得
    $(document).on('click', '.th-sort', function () {
        const sort = $(this).data('sort');
        const $sort = $form.find('input[name=sort]');
        const $dir = $form.find('input[name=dir]');

        if ($sort.val() === String(sort)) {
            $dir.val($dir.val() === 'asc' ? 'desc' : 'asc');
        } else {
            // 昇順デフォルト
            $sort.val(sort);
            $dir.val('asc');
        }
        fetchList($form.serialize());

    });

    // ページネーション（Ajax化）
    $(document).on('click', '#paginator a', function (e) {
        e.preventDefault();
        const href = this.href;
        const url = new URL(href);
        const page = url.searchParams.get('page') || 1;

        const params = $form.serializeArray();
        params.push({ name: 'page', value: page });

        fetchList($.param(params));
    });

    // 削除（Ajax）
    $(document).on('click', '.btn-delete', function () {
        if (!confirm('削除しますか？')) return;
        const id = $(this).data('id');
        const url = window.routes.deleteProduct.replace(':id', id);

        $.ajax({
            url: url,
            type: 'POST',
            data: { _method: 'DELETE', _token: $('meta[name=csrf-token]').attr('content') },
            success: function () { $('tr[data-row-id="' + id + '"]').remove(); },
            error: function (xhr) { alert('削除に失敗しました：' + xhr.status); }
        });
    });

});
