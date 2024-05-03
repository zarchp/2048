<?php

use function Livewire\Volt\{state};

//

?>

<x-layouts.app>
    @volt
        <div x-data="{
            {{-- board: [
                ['1', '2', '3', '4', '5', '6', '7', '8', '9'],
                Array(9).fill(''),
                Array(9).fill(''),
                Array(9).fill(''),
                Array(9).fill(''),
                Array(9).fill(''),
                Array(9).fill(''),
                Array(9).fill(''),
                Array(9).fill(''),
            ], --}}
            board: Array.from({ length: 9 }, () => Array(9).fill('')),
                activeCell: {},
                values: ['1', '2', '3', '4', '5', '6', '7', '8', '9'],
        }">
            <x-header title="Sudoku" size="text-3xl text-primary">
                <x-slot:actions>
                    <x-theme-toggle class="btn" title="Toggle Theme" />
                    <x-button label="" class="" x-on:click="$wire.drawerSettings = true" responsive
                        icon="o-adjustments-horizontal" title="Settings" />
                </x-slot:actions>
            </x-header>

            <div class="m-auto w-full h-[calc(100vh-8rem)] justify-center items-center flex flex-col gap-8 px-4">
                {{-- <div class="text-2xl">Winner: <span x-text="winner"></span></div> --}}
                {{-- <select class="max-w-xs max-24 select select-bordered select-sm" x-model="selectedDifficulty"
                    x-on:input="setBot($event.target.value)">
                    <template x-for="difficulty in difficulties">
                        <option x-text="difficulty" x-bind:selected="difficulty === selectedDifficulty"></option>
                    </template>
                </select> --}}
                <div class="grid grid-cols-9 border-4 rounded grid-rows-9">
                    <template x-for="(rows, rowIndex) in board">
                        <template x-for="(cols, colIndex) in rows">
                            <div class="flex items-center justify-center w-10 h-10 border-2 lg:w-20 lg:h-20"
                                x-bind:data-row="rowIndex" x-bind:data-col="colIndex"
                                x-on:click="activeCell = {col: colIndex, row: rowIndex}"
                                x-on:keydown.enter="console.log($event.target.value);"
                                x-bind:class="{
                                    'border-info': activeCell.row === rowIndex && activeCell.col === colIndex,
                                    {{--
                                        'border-t-0': [0, 1, 2, 3, 4, 5, 6, 7, 8].includes(index),
                                    'border-r-0': [0, 1, 2, 3, 4, 5, 6, 7, 8].includes(index2), --}}
                                    {{-- 'border-t-0': [0, 1, 2, 3, 4, 5, 6, 7, 8].includes(index2),
                                        'border-l-0': [0, 1, 2, 3, 4, 5, 6, 7, 8].includes(index2), --}}
                                    {{-- 'border-r-0': [0, 1, 2].includes(index2),
                                    'border-b-0': [0, 1, 2].includes(index2),
                                    'border-l-0': [0, 1, 2].includes(index2), --}}
                                }">
                                {{-- <div class="text-xl" x-text="rowIndex + ' - ' + colIndex"></div> --}}
                                <div class="text-xl" x-text="cols"></div>
                            </div>
                        </template>
                    </template>
                </div>

                <div class="grid grid-cols-9 gap-4 rounded">
                    <template x-for="(value, index) in values">
                        <div class="flex items-center justify-center w-10 h-10 border-2 cursor-pointer" x-text="value"
                            x-on:click="board[activeCell.row][activeCell.col] = value"></div>
                    </template>
                </div>


                {{-- <div>
                    <x-button icon="o-arrow-path" label="Restart" x-on:click="resetGame" />
                </div> --}}
            </div>
        </div>
    @endvolt
</x-layouts.app>
