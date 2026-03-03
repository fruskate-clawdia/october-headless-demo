<?php Block::put('breadcrumb') ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= Backend::url('demo/api/todos') ?>">Todos</a></li>
    </ol>
<?php Block::endPut() ?>

<?php $pct = $totalCount > 0 ? round($doneCount / $totalCount * 100) : 0; ?>

<style>
.todo-stats{margin-bottom:24px;padding:20px 24px 0}
.todo-stats .stats-eyebrow{font-size:11px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:#9CA3AF;margin-bottom:14px}
.todo-stats .stat-card{border:1px solid rgba(0,0,0,.07);border-left:3px solid var(--accent);border-radius:10px;padding:20px 24px;box-shadow:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);transition:box-shadow .18s ease,transform .18s ease;background:var(--card-bg)}
.todo-stats .stat-card:hover{box-shadow:0 4px 12px rgba(0,0,0,.10),0 2px 4px rgba(0,0,0,.06);transform:translateY(-2px)}
.todo-stats .stat-head{display:flex;align-items:center;justify-content:space-between;gap:12px}
.todo-stats .stat-icon{width:40px;height:40px;border-radius:8px;background:var(--icon-bg);display:flex;align-items:center;justify-content:center;font-size:17px;line-height:1;color:var(--accent);flex-shrink:0}
.todo-stats .stat-value{font-size:30px;font-weight:700;color:#111827;line-height:1;letter-spacing:-.03em;margin-top:0}
.todo-stats .stat-label{font-size:11px;font-weight:600;color:#6B7280;margin-top:6px;text-transform:uppercase;letter-spacing:.06em}
.todo-stats .completion-row{margin-top:12px;display:flex;align-items:center;gap:10px}
.todo-stats .completion-label{font-size:11px;font-weight:500;color:#9CA3AF;white-space:nowrap}
.todo-stats .completion-track{flex:1;height:5px;background:#E5E7EB;border-radius:99px;overflow:hidden}
.todo-stats .completion-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,#6366F1,#10B981)}
</style>

<div class="todo-stats">
    <div class="stats-eyebrow">Overview</div>
    <div class="row row-cols-xl-4 row-cols-md-2 row-cols-1 g-3">

        <div class="col">
            <div class="stat-card" style="--card-bg:#F7F8FA;--accent:#6366F1;--icon-bg:rgba(99,102,241,.10)">
                <div class="stat-head">
                    <div>
                        <div class="stat-value"><?= $totalCount ?></div>
                        <div class="stat-label">Total Tasks</div>
                    </div>
                    <div class="stat-icon"><i class="oc-icon-list-ul"></i></div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="stat-card" style="--card-bg:#FFF9F0;--accent:#F59E0B;--icon-bg:rgba(245,158,11,.10)">
                <div class="stat-head">
                    <div>
                        <div class="stat-value"><?= $pendingCount ?></div>
                        <div class="stat-label">Pending</div>
                    </div>
                    <div class="stat-icon"><i class="oc-icon-clock-o"></i></div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="stat-card" style="--card-bg:#F0FDF6;--accent:#10B981;--icon-bg:rgba(16,185,129,.10)">
                <div class="stat-head">
                    <div>
                        <div class="stat-value"><?= $doneCount ?></div>
                        <div class="stat-label">Completed</div>
                    </div>
                    <div class="stat-icon"><i class="oc-icon-check-circle"></i></div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="stat-card" style="--card-bg:#F0F4FF;--accent:#3B82F6;--icon-bg:rgba(59,130,246,.10)">
                <div class="stat-head">
                    <div>
                        <div class="stat-value"><?= $todayCount ?></div>
                        <div class="stat-label">Added Today</div>
                    </div>
                    <div class="stat-icon"><i class="oc-icon-calendar-plus-o"></i></div>
                </div>
            </div>
        </div>

    </div>

    <?php if ($totalCount > 0): ?>
    <div class="completion-row">
        <span class="completion-label"><?= $pct ?>% complete</span>
        <div class="completion-track">
            <div class="completion-fill" style="width:<?= $pct ?>%"></div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->listRender() ?>
