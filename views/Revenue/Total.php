<div class="col-12">
    <section class="hero-banner">
        <div class="banner-content text-center">
            <h1 class="fw-bold">Tổng Doanh Thu</h1>
            <p class="mb-4">Theo dõi doanh thu từ các đặt lịch sân bóng theo các khoảng thời gian khác nhau.</p>
        </div>
    </section>
</div>
<link rel="stylesheet" href="<?= BASE_URL ?>css/revenue.css">
<div class="col-12 mt-4">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card p-4 h-100 shadow-sm border-0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Biểu đồ doanh thu</h5>
                        <p class="text-muted mb-0">Xem doanh thu theo tuần, tháng, quý hoặc năm.</p>
                    </div>
                    <div class="d-flex gap-3 align-items-center">

    <div class="dropdown custom-dropdown">
        <button class="btn custom-btn dropdown-toggle" type="button">
            📊 Tuần hiện tại
        </button>

        <ul class="dropdown-menu custom-menu">
            <li><a class="dropdown-item" href="?period=week">📅 Tuần hiện tại</a></li>
            <li><a class="dropdown-item" href="?period=month">🗓️ Tháng trong năm</a></li>
            <li><a class="dropdown-item" href="?period=quarter">📈 Quý trong năm</a></li>
            <li><a class="dropdown-item" href="?period=year">🎯 Năm</a></li>
        </ul>
    </div>

    <button
        type="button"
        class="btn custom-add-btn"
        data-bs-toggle="modal"
        data-bs-target="#manualSeedModal">
        ➕ Thêm thủ công
    </button>

</div>  
                </div>
                <div id="periodCalendar" class="mb-3 rounded-3 p-3" style="background: #f8f9fa;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="fw-semibold">Lịch hiển thị:</span>
                            <span id="periodCalendarLabel" class="text-muted"></span>
                        </div>
                        <small id="periodCalendarHint" class="text-muted"></small>
                    </div>
                    <div id="periodCalendarItems" class="d-flex flex-wrap gap-2"></div>
                </div>
                                <div class="chart-wrapper" style="height:360px;max-height:360px;overflow:hidden;">
                                        <canvas id="revenueChart" style="width:100%;height:100%;"></canvas>
                                </div>
            
                                <!-- Manual seed modal -->
                                <div class="modal fade" id="manualSeedModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="post" action="<?= BASE_URL ?>?action=admin_revenue_seed">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Thêm doanh thu thủ công</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                        <label class="form-label">Chọn sân</label>
                                                        <select name="stadium_id" id="seedStadium" class="form-select" required>
                                                                <?php foreach ($stadiums as $s): ?>
                                                                        <option value="<?= $s['id'] ?>" data-price="<?= $s['price_per_hour'] ?>"><?= htmlspecialchars($s['name']) ?> - <?= number_format($s['price_per_hour'],0,',','.') ?>đ/giờ</option>
                                                                <?php endforeach; ?>
                                                        </select>
                                                </div>
                                                <div class="mb-3 row">
                                                        <div class="col-6">
                                                                <label class="form-label">Ngày</label>
                                                                <input type="date" name="date" class="form-control" required value="<?= date('Y-m-d') ?>">
                                                        </div>
                                                        <div class="col-6">
                                                                <label class="form-label">Giờ</label>
                                                                <input type="time" name="time" class="form-control" value="12:00">
                                                        </div>
                                                </div>
                                                <div class="mb-3">
                                                        <label class="form-label">Số giờ thuê</label>
                                                        <input type="number" name="hours" id="seedHours" min="0.5" step="0.5" class="form-control" value="1" required>
                                                </div>
                                                <div class="mb-3">
                                                        <label class="form-label">Tổng tiền</label>
                                                        <div id="seedTotal" class="fw-bold">0đ</div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                <button type="submit" id="seedSubmitBtn" class="btn btn-primary">
                                                    <span id="seedSpinner" class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                                                    <span id="seedSubmitText">Thêm</span>
                                                </button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card p-4 h-100 shadow-sm border-0">
                <h5 class="fw-bold mb-3">Tổng quan</h5>
                <div class="row g-3">
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background: #f8f9fa;">
                            <small class="text-muted">Doanh thu ngày</small>
                            <div class="d-flex justify-content-between align-items-end mt-2">
                                <span id="summaryDay" class="fw-bold display-6"><?php echo number_format($revenueByDay, 0, ',', '.'); ?>đ</span>
                                <span class="text-success">Hôm nay</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background: #f8f9fa;">
                            <small class="text-muted">Doanh thu tuần</small>
                            <div class="d-flex justify-content-between align-items-end mt-2">
                                <span id="summaryWeek" class="fw-bold display-6"><?php echo number_format($revenueByWeek, 0, ',', '.'); ?>đ</span>
                                <span class="text-success">Tuần hiện tại</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background: #f8f9fa;">
                            <small class="text-muted">Doanh thu tháng</small>
                            <div class="d-flex justify-content-between align-items-end mt-2">
                                <span id="summaryMonth" class="fw-bold display-6"><?php echo number_format($revenueByMonth, 0, ',', '.'); ?>đ</span>
                                <span class="text-success">Tháng hiện tại</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background: #f8f9fa;">
                            <small class="text-muted">Tổng doanh thu</small>
                            <div class="d-flex justify-content-between align-items-end mt-2">
                                <span id="summaryTotal" class="fw-bold display-6"><?php echo number_format($totalRevenue, 0, ',', '.'); ?>đ</span>
                                <span class="text-success">Toàn thời gian</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartDataMap = {
        week: <?php echo json_encode($chartSummary['week']); ?>,
        month: <?php echo json_encode($chartSummary['month']); ?>,
        quarter: <?php echo json_encode($chartSummary['quarter']); ?>,
        year: <?php echo json_encode($chartSummary['year']); ?>
    };

    const ctxEl = document.getElementById('revenueChart');
    const ctx = ctxEl ? ctxEl.getContext('2d') : null;
    let revenueChart;
    let currentPeriod = 'week';

    const dateLabels = {
        week: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'],
        month: Array.from({ length: 12 }, (_, i) => 'Tháng ' + (i + 1)),
        quarter: ['Quý 1', 'Quý 2', 'Quý 3', 'Quý 4'],
        year: []
    };

    function getCalendarDisplay(period, payload) {
        const items = [];

        if (period === 'week') {
            const now = new Date();
            const monday = new Date(now);
            const day = monday.getDay();
            const diff = day === 0 ? -6 : 1 - day;
            monday.setDate(monday.getDate() + diff);

            for (let i = 0; i < 7; i++) {
                const d = new Date(monday);
                d.setDate(monday.getDate() + i);
                const label = d.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit' });
                const value = payload.data[i] || 0;
                items.push({ label, value });
            }
            return {
                title: monday.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit' }) + ' - ' + new Date(monday.getFullYear(), monday.getMonth(), monday.getDate() + 6).toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit' }),
                hint: 'Tuần hiện tại',
                items
            };
        }

        if (period === 'month') {
            const year = new Date().getFullYear();
            for (let i = 0; i < 12; i++) {
                items.push({ label: 'Tháng ' + (i + 1), value: payload.data[i] || 0 });
            }
            return {
                title: 'Năm ' + year,
                hint: '12 tháng trong năm',
                items
            };
        }

        if (period === 'quarter') {
            const year = new Date().getFullYear();
            for (let i = 0; i < 4; i++) {
                items.push({ label: 'Quý ' + (i + 1), value: payload.data[i] || 0 });
            }
            return {
                title: 'Năm ' + year,
                hint: '4 quý trong năm',
                items
            };
        }

        const years = payload.labels.length ? payload.labels : [new Date().getFullYear().toString()];
        for (let i = 0; i < years.length; i++) {
            items.push({ label: years[i], value: payload.data[i] || 0 });
        }
        return {
            title: 'Theo năm',
            hint: 'Dữ liệu theo năm',
            items
        };
    }

    function renderPeriodCalendar(period, payload) {
        const display = getCalendarDisplay(period, payload);
        const calendarLabel = document.getElementById('periodCalendarLabel');
        const calendarHint = document.getElementById('periodCalendarHint');
        const calendarItems = document.getElementById('periodCalendarItems');

        calendarLabel.textContent = display.title;
        calendarHint.textContent = display.hint;
        calendarItems.innerHTML = display.items.map(item => `
            <div class="flex-fill rounded-3 p-2 border" style="min-width: 88px; background:#fff;">
                <div class="text-small text-muted">${item.label}</div>
                <div class="fw-bold">${new Intl.NumberFormat('vi-VN').format(item.value)}đ</div>
            </div>
        `).join('');
    }

    function getScaleConfig(maxValue) {
        const minStep = 1000000;
        const fixedMax = Math.max(minStep, maxValue);
        let stepSize = minStep;

        if (fixedMax <= 1000000) {
            stepSize = 1000000;
        } else if (fixedMax <= 2500000) {
            stepSize = 500000;
        } else if (fixedMax <= 5000000) {
            stepSize = 1000000;
        } else if (fixedMax <= 10000000) {
            stepSize = 2500000;
        } else {
            const rawStep = Math.ceil(fixedMax / 4 / minStep) * minStep;
            stepSize = rawStep;
        }

        const suggestedMax = Math.ceil(fixedMax / stepSize) * stepSize;

        return {
            min: 0,
            suggestedMin: 0,
            max: suggestedMax,
            suggestedMax,
            ticks: {
                stepSize,
                callback: function(value) {
                    return new Intl.NumberFormat('vi-VN').format(value) + 'đ';
                }
            }
        };
    }

    function renderChart(period) {
        const payload = chartDataMap[period] || chartDataMap.week;

        if (!Array.isArray(payload.labels) || payload.labels.length === 0) {
            if (period === 'week') {
                payload.labels = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'];
            } else if (period === 'month') {
                payload.labels = Array.from({ length: 12 }, (_, i) => 'Tháng ' + (i + 1));
            } else if (period === 'quarter') {
                payload.labels = ['Quý 1', 'Quý 2', 'Quý 3', 'Quý 4'];
            } else {
                payload.labels = [new Date().getFullYear().toString()];
            }
        }

        if (!Array.isArray(payload.data)) {
            payload.data = [];
        }

        while (payload.data.length < payload.labels.length) {
            payload.data.push(0);
        }

        renderPeriodCalendar(period, payload);

        const maxDataValue = payload.data.reduce((acc, value) => Math.max(acc, value), 0);
        const yScale = getScaleConfig(maxDataValue);

        // green-yellow-red gradient: green at low values, yellow mid, red at high values
        const bgColors = payload.data.map(v => {
            const ratio = maxDataValue ? (v / maxDataValue) : 0;
            const hue = Math.max(0, 120 - Math.round(ratio * 120)); // 120 (green) -> 0 (red)
            const sat = 85;
            const topLight = 75 - Math.round(ratio * 20); // bright top
            const bottomLight = 45 - Math.round(ratio * 12); // darker bottom
            const light = `hsl(${hue}, ${sat}%, ${topLight}%)`;
            const dark = `hsl(${hue}, ${sat}%, ${bottomLight}%)`;
            const g = ctx.createLinearGradient(0, 0, 0, ctxEl.height || 360);
            g.addColorStop(0, light);
            g.addColorStop(1, dark);
            return g;
        });

        const borderColors = payload.data.map(v => {
            const ratio = maxDataValue ? (v / maxDataValue) : 0;
            const hue = Math.max(0, 120 - Math.round(ratio * 120));
            return `hsl(${hue}, 90%, 25%)`;
        });

        const chartConfig = {
            type: 'bar',
            data: {
                labels: payload.labels,
                datasets: [{
                    label: 'Doanh thu',
                    data: payload.data,
                    backgroundColor: bgColors,
                    borderColor: borderColors,
                    borderWidth: 1,
                    borderRadius: 8,
                    barPercentage: 0.7,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('vi-VN').format(context.parsed.y) + 'đ';
                        }
                    }}
                },
                scales: {
                    x: { grid: { display: false } },
                    y: yScale
                }
            }
        };

        if (revenueChart) {
            revenueChart.destroy();
        }

        revenueChart = new Chart(ctx, chartConfig);
    }

    // Initialize chart based on URL `period` query or default 'week'
    function getQueryPeriod() {
        try {
            const params = new URLSearchParams(window.location.search);
            const p = params.get('period');
            if (p && ['week','month','quarter','year'].includes(p)) return p;
        } catch (e) {}
        return 'week';
    }

    // Update dropdown button label
    function setDropdownLabel(period) {
        const btn = document.querySelector('.custom-dropdown > .custom-btn');
        if (!btn) return;
        const map = { week: '📊 Tuần hiện tại', month: '🗓️ Tháng trong năm', quarter: '📈 Quý trong năm', year: '🎯 Năm' };
        btn.textContent = map[period] || map.week;
    }

    // Attach click handlers to custom menu items so chart updates without full reload
    (function bindMenuClicks() {
        const items = document.querySelectorAll('.custom-menu .dropdown-item');
        items.forEach(a => {
            a.addEventListener('click', function(ev) {
                ev.preventDefault();
                const href = this.getAttribute('href') || '';
                const p = (new URLSearchParams(href.split('?')[1] || '')).get('period') || 'week';
                // update URL (soft) and render
                const url = new URL(window.location.href);
                url.searchParams.set('period', p);
                window.history.pushState({}, '', url);
                setDropdownLabel(p);
                renderChart(p);
            });
        });
    })();

    const initialPeriod = getQueryPeriod();
    setDropdownLabel(initialPeriod);
    renderChart(initialPeriod);

    // Seed modal total calculation
    function formatVND(value) {
        return new Intl.NumberFormat('vi-VN').format(value) + 'đ';
    }

    function updateSeedTotal() {
        const stadiumEl = document.getElementById('seedStadium');
        const hoursEl = document.getElementById('seedHours');
        if (!stadiumEl || !hoursEl) return;
        const price = parseFloat(stadiumEl.selectedOptions[0].dataset.price || 0);
        const hours = parseFloat(hoursEl.value || 0);
        const total = Math.max(0, price * hours);
        const totalEl = document.getElementById('seedTotal');
        if (totalEl) totalEl.textContent = formatVND(total);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const stadiumEl = document.getElementById('seedStadium');
        const hoursEl = document.getElementById('seedHours');
        if (stadiumEl) stadiumEl.addEventListener('change', updateSeedTotal);
        if (hoursEl) hoursEl.addEventListener('input', updateSeedTotal);

        // update when modal opens
        const manualModal = document.getElementById('manualSeedModal');
        if (manualModal) {
            manualModal.addEventListener('shown.bs.modal', function() {
                updateSeedTotal();
            });
        }
    });

    // Modern AJAX submit (non-blocking) for manual seed form
    (function() {
        const form = document.querySelector('#manualSeedModal form');
        if (!form) return;
        const submitBtn = document.getElementById('seedSubmitBtn');
        const spinner = document.getElementById('seedSpinner');

        function showSpinner(show) {
            if (!spinner) return;
            spinner.classList.toggle('d-none', !show);
        }

        // toast helper
        function showToast(message, type = 'success') {
            const wrapper = document.createElement('div');
            wrapper.className = 'position-fixed bottom-0 end-0 p-3';
            const bg = type === 'success' ? 'text-bg-success' : 'text-bg-danger';
            wrapper.innerHTML = `<div class="toast show align-items-center ${bg} border-0" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">${message}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>`;
            document.body.appendChild(wrapper);
            setTimeout(() => wrapper.remove(), 2600);
        }

        form.addEventListener('submit', function(ev) {
            ev.preventDefault();

            if (submitBtn) submitBtn.setAttribute('disabled', '');
            showSpinner(true);

            const fd = new FormData(form);
            fd.append('ajax', '1');

            fetch(form.action, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(async r => {
                // attempt to parse JSON, fallback to text
                let payload;
                try {
                    payload = await r.json();
                } catch (e) {
                    const txt = await r.text();
                    payload = { success: false, error: 'Server response not JSON: ' + txt.substring(0,200) };
                }
                return payload;
            })
            .then(resp => {
                showSpinner(false);
                if (submitBtn) submitBtn.removeAttribute('disabled');

                if (resp && resp.success) {
                    if (resp.summary) {
                        document.getElementById('summaryDay').textContent = new Intl.NumberFormat('vi-VN').format(resp.summary.day) + 'đ';
                        document.getElementById('summaryWeek').textContent = new Intl.NumberFormat('vi-VN').format(resp.summary.week) + 'đ';
                        document.getElementById('summaryMonth').textContent = new Intl.NumberFormat('vi-VN').format(resp.summary.month) + 'đ';
                        document.getElementById('summaryTotal').textContent = new Intl.NumberFormat('vi-VN').format(resp.summary.total) + 'đ';
                    }

                    if (resp.chartSummary) {
                        chartDataMap.week = resp.chartSummary.week;
                        chartDataMap.month = resp.chartSummary.month;
                        chartDataMap.quarter = resp.chartSummary.quarter;
                        chartDataMap.year = resp.chartSummary.year;
                        const periodEl = document.getElementById('revenuePeriod');
                        const period = periodEl ? periodEl.value : 'week';
                        renderChart(period);
                    }

                    const modalEl = document.getElementById('manualSeedModal');
                    if (window.bootstrap && bootstrap.Modal) {
                        const bsModal = bootstrap.Modal.getInstance(modalEl);
                        if (bsModal) bsModal.hide();
                    }

                    showToast('Thêm thành công.', 'success');
                } else {
                    showToast('Lỗi: ' + (resp && resp.error ? resp.error : 'Không thể thêm dữ liệu'), 'danger');
                }
            }).catch(err => {
                showSpinner(false);
                if (submitBtn) submitBtn.removeAttribute('disabled');
                showToast('Lỗi mạng hoặc máy chủ: ' + (err.message || err), 'danger');
            });
        });
    })();

    // The form submits normally (no AJAX) to allow full page reload and server-side handling.
</script>

<div class="col-12 mt-4">
    <div class="card p-4 border-0 shadow-sm">
        <h5 class="fw-bold mb-3">Thống Kê Chi Tiết</h5>
        <div class="row g-3">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Khoảng Thời Gian</th>
                                <th class="text-end">Doanh Thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Hôm nay</td>
                                <td class="text-end fw-bold"><?php echo number_format($revenueByDay, 0, ',', '.'); ?>đ</td>
                            </tr>
                            <tr>
                                <td>Tuần hiện tại</td>
                                <td class="text-end fw-bold"><?php echo number_format($revenueByWeek, 0, ',', '.'); ?>đ</td>
                            </tr>
                            <tr>
                                <td>Tháng hiện tại</td>
                                <td class="text-end fw-bold"><?php echo number_format($revenueByMonth, 0, ',', '.'); ?>đ</td>
                            </tr>
                            <tr>
                                <td>Quý hiện tại</td>
                                <td class="text-end fw-bold"><?php echo number_format($revenueByQuarter, 0, ',', '.'); ?>đ</td>
                            </tr>
                            <tr>
                                <td>Năm hiện tại</td>
                                <td class="text-end fw-bold"><?php echo number_format($revenueByYear, 0, ',', '.'); ?>đ</td>
                            </tr>
                            <tr class="table-info">
                                <td><strong>Tổng doanh thu toàn thời gian</strong></td>
                                <td class="text-end"><strong><?php echo number_format($totalRevenue, 0, ',', '.'); ?>đ</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
