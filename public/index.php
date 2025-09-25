<?php
// MathsterMind - Beginner PHP frontend to run the Python Sudoku solver.
// This uses a simple shell call to execute Python and prints the puzzle before/after.

// Location of the Python script relative to this file
$solverPath = __DIR__ . '/../src/python/sudoku_solver.py';

// Sanity check
if (!file_exists($solverPath)) {
    http_response_code(500);
    echo "Python solver not found.";
    exit;
}

// Execute the Python solver and capture the output
$pythonCmd = 'python "' . $solverPath . '"';
exec($pythonCmd, $outputLines, $exitCode);

// Parse output: first line should be SOLVED/UNSOLVABLE, rest is 9 lines of CSV rows
$status = $outputLines[0] ?? 'UNKNOWN';
$rows = array_slice($outputLines, 1);

function renderGrid($rows) {
    echo '<table class="sudoku">';
    foreach ($rows as $r => $csv) {
        echo '<tr>';
        $cells = explode(',', trim($csv));
        foreach ($cells as $c => $val) {
            $classes = [];
            if ($r % 3 === 0) { $classes[] = 'top'; }
            if ($c % 3 === 0) { $classes[] = 'left'; }
            if ($r === 8) { $classes[] = 'bottom'; }
            if ($c === 8) { $classes[] = 'right'; }
            $classAttr = $classes ? ' class="' . implode(' ', $classes) . '"' : '';
            echo '<td' . $classAttr . '>' . htmlspecialchars($val) . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MathsterMind - Sudoku Solver</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f7f7fb; }
    h1 { margin-bottom: 0.25rem; }
    .status { margin: 0.5rem 0 1rem; font-weight: bold; }
    .grid { display: inline-block; margin-right: 40px; }
    table.sudoku { border-collapse: collapse; }
    table.sudoku td { width: 32px; height: 32px; text-align: center; vertical-align: middle; border: 1px solid #999; background: #fff; }
    table.sudoku td.top { border-top: 2px solid #000; }
    table.sudoku td.left { border-left: 2px solid #000; }
    table.sudoku td.right { border-right: 2px solid #000; }
    table.sudoku td.bottom { border-bottom: 2px solid #000; }
    .wrap { display: flex; gap: 2rem; flex-wrap: wrap; }
    .panel { background: white; padding: 12px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .footer { margin-top: 2rem; color: #666; font-size: 0.9rem; }
    .btn { display: inline-block; padding: 8px 12px; background: #4a67ff; color: white; text-decoration: none; border-radius: 6px; }
  </style>
</head>
<body>
  <h1>MathsterMind</h1>
  <div class="status">Status: <?php echo htmlspecialchars($status); ?></div>
  <div class="wrap">
    <div class="panel">
      <h3>Solution</h3>
      <?php renderGrid($rows); ?>
    </div>
  </div>

  <div class="footer">
    <p>This is a beginner-friendly Sudoku solver using Python for logic and PHP for display.</p>
  </div>
</body>
</html>
