#!/usr/bin/env python3

# MathsterMind - Beginner Sudoku Solver
# Simple backtracking solver with a hardcoded puzzle for clarity.
# 0 represents an empty cell.

from typing import List, Optional, Tuple

Grid = List[List[int]]

HARDCODED_PUZZLE: Grid = [
    [0, 0, 0, 2, 6, 0, 7, 0, 1],
    [6, 8, 0, 0, 7, 0, 0, 9, 0],
    [1, 9, 0, 0, 0, 4, 5, 0, 0],
    [8, 2, 0, 1, 0, 0, 0, 4, 0],
    [0, 0, 4, 6, 0, 2, 9, 0, 0],
    [0, 5, 0, 0, 0, 3, 0, 2, 8],
    [0, 0, 9, 3, 0, 0, 0, 7, 4],
    [0, 4, 0, 0, 5, 0, 0, 3, 6],
    [7, 0, 3, 0, 1, 8, 0, 0, 0],
]


def find_empty(grid: Grid) -> Optional[Tuple[int, int]]:
    """Find the next empty cell (row, col) or return None if full."""
    for r in range(9):
        for c in range(9):
            if grid[r][c] == 0:
                return r, c
    return None


def is_valid(grid: Grid, row: int, col: int, val: int) -> bool:
    """Check if placing val at (row, col) is valid."""
    # Row check
    if any(grid[row][i] == val for i in range(9)):
        return False
    # Column check
    if any(grid[i][col] == val for i in range(9)):
        return False
    # 3x3 subgrid check
    box_row = (row // 3) * 3
    box_col = (col // 3) * 3
    for r in range(box_row, box_row + 3):
        for c in range(box_col, box_col + 3):
            if grid[r][c] == val:
                return False
    return True


def solve(grid: Grid) -> bool:
    """Solve the Sudoku puzzle using backtracking. Returns True if solved."""
    empty = find_empty(grid)
    if not empty:
        return True  # No empty cells: solved

    row, col = empty
    for val in range(1, 10):
        if is_valid(grid, row, col, val):
            grid[row][col] = val
            if solve(grid):
                return True
            grid[row][col] = 0  # backtrack
    return False


def format_grid(grid: Grid) -> str:
    """Return grid as a simple 9x9 CSV-like string rows."""
    return "\n".join(",".join(str(n) for n in row) for row in grid)


if __name__ == "__main__":
    # Copy the hardcoded puzzle so we don't mutate the constant
    board = [row[:] for row in HARDCODED_PUZZLE]
    solvable = solve(board)
    status = "SOLVED" if solvable else "UNSOLVABLE"
    print(status)
    print(format_grid(board))
