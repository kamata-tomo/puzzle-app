@extends('layouts.app')
@section('title', 'ステージ情報')
@section('body')


    <div class="container py-4">
        <div class="d-flex gap-2 mb-3">
            <a href="/TOP/index" class="btn btn-secondary shadow-sm">🏠 管理画面TOP</a>
            <a href="{{ route('stages.index') }}" class="btn btn-primary shadow-sm">📋 ステージ一覧</a>
        </div>
        <h1 class="mb-4 fw-bold text-center">🎮 ステージ情報エディタ</h1>

        <form method="POST" action="{{ route('stages.store') }}" id="stageForm">
            @csrf

            <!-- 基本情報 -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body bg-dark text-light rounded-3">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="chapter_num" class="form-label">チャプター番号</label>
                            <input type="number" class="form-control" id="chapter_num" name="chapter_num"
                                   value="{{ old('chapter_num', $stage->chapter_num ?? '') }}" required>
                        </div>
                        <div class="col">
                            <label for="stage_num" class="form-label">ステージID</label>
                            <input type="number" class="form-control" id="stage_num" name="stage_num"
                                   value="{{ old('stage_num', $stage->stage_num ?? '') }}" required>
                        </div>
                    </div>
                    {{--                   <div class="form-check mb-3">
                                            <input type="hidden" name="score_criteria_is_time" value="0">
                                            <input class="form-check-input" type="checkbox" name="score_criteria_is_time" value="1" id="isTime"
                                                {{ old('score_criteria_is_time', $stage->score_criteria_is_time ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isTime">
                            スコア基準は <strong>時間</strong> である
                        </label>
                    </div>--}}
                    <div class="row mb-3">
                        <div class="col">
                            <label for="reference_value_1" class="form-label">⭐ 星1基準値</label>
                            <input type="number" class="form-control" id="reference_value_1" name="reference_value_1"
                                   value="{{ old('reference_value_1', $stage->reference_value_1 ?? '') }}" required>
                        </div>
                        <div class="col">
                            <label for="reference_value_2" class="form-label">⭐ 星2基準値</label>
                            <input type="number" class="form-control" id="reference_value_2" name="reference_value_2"
                                   value="{{ old('reference_value_2', $stage->reference_value_2 ?? '') }}" required>
                        </div>
                        <div class="col">
                            <label for="reference_value_3" class="form-label">⭐ 星3基準値</label>
                            <input type="number" class="form-control" id="reference_value_3" name="reference_value_3"
                                   value="{{ old('reference_value_3', $stage->reference_value_3 ?? '') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="shuffle_count" class="form-label">🔄 シャッフル回数</label>
                        <input type="number" class="form-control" id="shuffle_count" name="shuffle_count" min="0"
                               value="{{ old('shuffle_count', $stage->shuffle_count ?? 0) }}" required>
                    </div>
                </div>
            </div>

            <!-- エディタ部分 -->
            <div class="row">
                <div class="col-md-8 mb-3">
                    <h4>ステージ配置（4x4）</h4>
                    <canvas id="stageCanvas" width="400" height="400" class="border border-light shadow-sm bg-dark rounded-2"></canvas>
                </div>
                <div class="col-md-4">
                    <h4>パレット</h4>
                    <div class="mb-3">
                        <h5 class="mb-2">ピース</h5>
                        @for($i=0; $i<=6; $i++)
                            <button type="button" class="palette-btn" onclick="selectTool({{ $i }}, this)">
                                <img src="{{ asset('images/pieces/type'.$i.'.png') }}" class="palette-icon">
                            </button>
                        @endfor
                    </div>
                    <div class="mb-3">
                        <h5 class="mb-2">収集アイテム</h5>
                        <button type="button" class="palette-btn" onclick="selectTool('collectible', this)">
                            <img src="{{ asset('images/pieces/collectibles.png') }}" class="palette-icon">
                        </button>
                    </div>
                    <div class="mb-3">
                        <h5 class="mb-2">ツール</h5>
                        <button type="button" class="palette-btn" onclick="selectTool('eraser-piece', this)">🧹 ピース消し</button>
                        <button type="button" class="palette-btn" onclick="selectTool('eraser-collectible', this)">🧹 アイテム消し</button>
                    </div>
                </div>
            </div>

            <input type="hidden" name="cells" id="cellsInput">

            <div class="text-center">
                <button type="submit" class="btn btn-lg btn-success px-5 mt-3 shadow">💾 保存</button>
            </div>
        </form>

    </div>

    <style>
        .palette-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            margin: 5px;
            border-radius: 8px;
            background-color: #2c2c2c;
            border: 2px solid #444;
            transition: all 0.2s ease;
            cursor: pointer;
            color: #fff;
            font-size: 14px;
        }
        .palette-btn:hover {
            background-color: #3a3a3a;
            border-color: #888;
        }
        .palette-btn.selected {
            border-color: #00bfff;
            background-color: #1e3f66;
            box-shadow: 0 0 10px #00bfff;
        }
        .palette-icon {
            max-width: 80%;
            max-height: 80%;
            pointer-events: none;
        }
    </style>

    <script>
        const canvas = document.getElementById('stageCanvas');
        const ctx = canvas.getContext('2d');
        const gridSize = 4;
        const cellSize = canvas.width / gridSize;

        let currentTool = null;
        let placedPieces = Array.from({ length: gridSize }, () => Array(gridSize).fill(null));
        let placedCollectibles = Array.from({ length: gridSize }, () => Array(gridSize).fill(false));

        const images = {};
        for (let i = 0; i <= 6; i++) {
            images[i] = new Image();
            if (i < 6) images[i].src = `/images/pieces/type${i}.png`;
        }
        images['collectible'] = new Image();
        images['collectible'].src = `/images/pieces/collectibles.png`;

        function selectTool(tool, el) {
            currentTool = tool;
            document.querySelectorAll(".palette-btn").forEach(btn => btn.classList.remove("selected"));
            if (el) el.classList.add("selected");
        }

        canvas.addEventListener('click', (e) => {
            const rect = canvas.getBoundingClientRect();
            const x = Math.floor((e.clientX - rect.left) / cellSize);
            const y = Math.floor((e.clientY - rect.top) / cellSize);
            if (currentTool === null) return;

            if (currentTool === 'eraser-piece') {
                placedPieces[y][x] = null;
            } else if (currentTool === 'eraser-collectible') {
                placedCollectibles[y][x] = false;
            } else if (currentTool === 'collectible') {
                placedCollectibles[y][x] = true;
            } else {
                placedPieces[y][x] = currentTool;
            }
            drawGrid();
        });

        function drawGrid() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.strokeStyle = "#666";
            for (let y = 0; y < gridSize; y++) {
                for (let x = 0; x < gridSize; x++) {
                    ctx.strokeRect(x * cellSize, y * cellSize, cellSize, cellSize);
                    if (placedPieces[y][x] !== null && images[placedPieces[y][x]]) {
                        ctx.drawImage(images[placedPieces[y][x]], x * cellSize, y * cellSize, cellSize, cellSize);
                    }
                    if (placedCollectibles[y][x]) {
                        ctx.drawImage(images['collectible'], x * cellSize, y * cellSize, cellSize, cellSize);
                    }
                }
            }
        }

        document.getElementById('stageForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const cells = [];
            let type6Count = 0;
            let collectibleCount = 0;
            let nullFound = false;

            for (let y = 0; y < gridSize; y++) {
                for (let x = 0; x < gridSize; x++) {
                    let pieceType = placedPieces[y][x];
                    let collectible = placedCollectibles[y][x];

                    if (pieceType === null) nullFound = true;
                    if (pieceType === 6) type6Count++;
                    if (collectible) collectibleCount++;

                    cells.push({
                        x: x,
                        y: y,
                        piece_type: (pieceType !== null ? pieceType : 0),
                        collectibles: !!collectible
                    });
                }
            }

            if (nullFound) {
                alert("全てのマスにピースを配置してください。");
                return;
            }
            if (type6Count !== 1) {
                alert("type6（空白）は必ず1つだけ配置してください。");
                return;
            }
            if (collectibleCount !== 1) {
                alert("収集アイテムは必ず1つだけ配置してください。");
                return;
            }

            document.getElementById('cellsInput').value = JSON.stringify(cells);
            this.submit();
        });

        // --- 編集モードのとき既存データを反映 ---
        @if(isset($stage))
        const existingCells = @json($stage->cells);
        existingCells.forEach(cell => {
            placedPieces[cell.y][cell.x] = cell.piece_type;
            placedCollectibles[cell.y][cell.x] = !!cell.collectibles;
        });
        @endif

        drawGrid();
    </script>
@endsection
