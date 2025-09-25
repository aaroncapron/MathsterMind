# MathsterMind

Beginner-coded math puzzle solver that starts with Sudoku.

- Logic: Python backtracking solver
- Frontend: Simple PHP page running the solver and showing the result

## Getting started (Windows)

1. Make sure you have Python 3 installed and accessible from the command line as `python` or `py`.
2. Make sure you have PHP installed (ex: from PHP for Windows or XAMPP).
3. From a terminal, start the PHP built-in server in the `public` folder:

```cmd
cd "c:\Users\aaron\OneDrive\Desktop\Workspace\+Coding Projects\Spam Filter\MathsterMind\public"
php -S localhost:8000
```

4. Open http://localhost:8000 in your browser.

## How it works

- The Python script prints two things:
  - First line: `SOLVED` or `UNSOLVABLE`
  - Next 9 lines: the 9x9 grid as CSV rows
- The PHP file executes the script and renders a styled 9x9 table.

## Change the puzzle

Open `src/python/sudoku_solver.py` and edit the `HARDCODED_PUZZLE`. Use `0` for empty cells. Refresh the page to see the new solution.

## Next steps

- Add an HTML form to paste a puzzle and pass it to Python (via a temporary file or stdin)
- Add validation and error handling
- Show the initial puzzle next to the solved grid
- Measure solving time
