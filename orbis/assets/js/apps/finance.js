(function($) {
    'use strict';

    window.OrbisFinance = {
        init: function() {
            this.load();
            this.bindEvents();
        },

        load: function() {
            const $list = $('#orbis-transactions-list');
            if (!$list.length) return;

            $.post(orbis_params.ajax_url, {
                action: 'orbis_get_finance_data',
                nonce: orbis_params.nonce
            }, function(response) {
                if (response.success) {
                    let balance = 0, income = 0, expense = 0, html = '';

                    response.data.forEach(t => {
                        const amt = parseFloat(t.amount);
                        if (t.type === 'income') { balance += amt; income += amt; }
                        else { balance -= amt; expense += amt; }

                        html += `
                            <div class="transaction-item ${t.type}">
                                <div><strong>${t.desc}</strong><br><small>${t.date}</small></div>
                                <div class="amount">${t.type === 'income' ? '+' : '-'}$${amt.toFixed(2)}</div>
                            </div>
                        `;
                    });

                    $('#orbis-finance-balance').text(`$${balance.toFixed(2)}`);
                    $('#orbis-finance-income').text(`$${income.toFixed(2)}`);
                    $('#orbis-finance-expense').text(`$${expense.toFixed(2)}`);
                    $list.html(html || '<p>No transactions recorded.</p>');
                }
            });
        },

        bindEvents: function() {
            const self = this;
            $('#orbis-add-transaction-btn').on('click', () => $('#orbis-transaction-modal').fadeIn());

            $('#orbis-transaction-form').on('submit', function(e) {
                e.preventDefault();
                const data = $(this).serialize() + '&action=orbis_save_transaction&nonce=' + orbis_params.nonce;
                $.post(orbis_params.ajax_url, data, () => {
                    $('#orbis-transaction-modal').fadeOut();
                    self.load();
                });
            });
        }
    };

    $(function() {
        if ($('#orbis-transactions-list').length) window.OrbisFinance.init();
    });

})(jQuery);
