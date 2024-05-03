<?php

use function Livewire\Volt\{state};

//

?>

<x-layouts.app>
    @volt
        <div x-data="{
            board: [{
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, {
                value: '',
                isMerged: false,
                color: '',
            }, ],
            starters: [2, 2, 2, 2, 2, 2, 2, 4],
            startGame() {
                this.resetGame();
                this.newValue();
                this.newValue();
            },
            resetGame() {
                for (index = 0; index <= 15; index++) {
                    this.board[index].value = '';
                }
            },
            randomIntFromInterval(min, max) {
                return Math.floor(Math.random() * (max - min + 1) + min);
            },
            newValue() {
                let index = this.randomIntFromInterval(0, 15);
                while (this.board[index].value !== '') {
                    index = this.randomIntFromInterval(0, 15);
                }
                let starterIndex = this.randomIntFromInterval(0, 5);
                this.board[index].value = this.starters[starterIndex];
            },
            isEmptyCell(index) {
                return this.board[index].value === '';
            },
            replaceCell(index, newIndex) {
                let oldValue = this.board[index].value;
                let newValue = this.board[newIndex].value;
        
                if (newValue === '') {
                    this.board[newIndex].value = oldValue;
                    this.board[index].value = '';
                }
            },
            mergeCell(index, newIndex) {
                let oldValue = parseInt(this.board[index].value);
                let oldIsMerged = this.board[index].isMerged;
                let newValue = parseInt(this.board[newIndex].value);
                let newIsMerged = this.board[newIndex].isMerged;
        
                if (oldValue === newValue && !oldIsMerged && !newIsMerged) {
                    this.board[newIndex].value = oldValue + newValue;
                    this.board[newIndex].isMerged = true;
                    this.board[index].value = '';
                }
                {{-- console.table(this.board); --}}
            },
            moveCell(index, newIndex) {
                console.log('old: ' + index);
                console.log('new: ' + newIndex);
                this.replaceCell(index, newIndex);
                this.mergeCell(index, newIndex);
            },
            resetIsMerged(index) {
                for (index = 0; index <= 15; index++) {
                    this.board[index].isMerged = false;
                }
            },
            move(direction) {
                switch (direction) {
                    case 'up':
                        this.moveUp();
                        break;
                    case 'down':
                        this.moveDown();
                        break;
                    case 'left':
                        this.moveLeft();
                        break;
                    case 'right':
                        this.moveRight();
                        break;
                    default:
                        break;
                }
        
                this.resetIsMerged();
                this.newValue();
                {{-- console.table(this.board); --}}
            },
            moveUp(depth = 0) {
                console.log('up');
                if (depth === 3) {
                    return;
                }
        
                let currentDepth = depth;
        
                for (index = 4; index <= 15; index++) {
                    if (this.isEmptyCell(index)) {
                        continue;
                    }
        
                    let newIndex = index - 4;
                    this.moveCell(index, newIndex);
        
                    if (newIndex >= 3) {
                        this.moveUp(depth + 1);
                    }
                    depth = 0;
                }
            },
            moveDown(depth = 0) {
                console.log('down');
                if (depth === 3) {
                    return;
                }
        
                let currentDepth = depth;
                console.log(currentDepth);
        
                for (index = 11; index >= 0; index--) {
                    if (this.isEmptyCell(index)) {
                        continue;
                    }
        
                    let newIndex = index + 4;
                    this.moveCell(index, newIndex);
        
                    if (newIndex <= 11) {
                        this.moveDown(depth + 1);
                    }
                    depth = 0;
                }
            },
            moveLeft(depth = 0) {
                console.log('left');
                if (depth === 3) {
                    return;
                }
        
                let currentDepth = depth;
        
                const skip = [0, 4, 8, 12];
                for (index = 0; index <= 15; index++) {
                    if (this.isEmptyCell(index) || skip.includes(index)) {
                        continue;
                    }
        
                    let newIndex = index - 1;
                    this.moveCell(index, newIndex);
        
                    if (!skip.includes(newIndex)) {
                        this.moveLeft(depth + 1);
                    }
                    depth = currentDepth;
                }
            },
            moveRight(depth = 0) {
                console.log('right');
                if (depth === 3) {
                    return;
                }
        
                let currentDepth = depth;
        
                const skip = [3, 7, 11, 15];
                for (index = 15; index >= 0; index--) {
                    if (this.isEmptyCell(index) || skip.includes(index)) {
                        continue;
                    }
        
                    let newIndex = index + 1;
                    this.moveCell(index, newIndex);
        
                    if (!skip.includes(newIndex)) {
                        console.log(depth);
                        this.moveRight(depth + 1);
                    }
                    depth = currentDepth;
                }
            },
        }" x-init="startGame()">
            <x-header title="2K48" size="text-3xl text-primary">
                <x-slot:actions>
                    <x-theme-toggle class="btn" title="Toggle Theme" />
                    <x-button label="" class="" x-on:click="$wire.drawerSettings = true" responsive
                        icon="o-adjustments-horizontal" title="Settings" />
                </x-slot:actions>
            </x-header>

            <div class="m-auto w-full h-[calc(100vh-8rem)] justify-center items-center flex flex-col gap-8 px-4"
                x-on:keydown.up.window="move('up')" x-swipe:up="move('up')" x-on:keydown.down.window="move('down')"
                x-swipe:down="move('down')" x-on:keydown.left.window="move('left')" x-swipe:left="move('left')"
                x-on:keydown.right.window="move('right')" x-swipe:right="move('right')">

                <div class="grid grid-cols-4 grid-rows-4 border-2 rounded border-base-content">
                    <template x-for="(cell, index) in board">
                        <div
                            class="flex items-center justify-center w-20 h-20 border-2 border-base-content lg:w-20 lg:h-20">
                            <div class="text-4xl font-bold" x-text="cell.value"></div>
                        </div>
                    </template>
                </div>

                <div>
                    <x-button class="btn-primary" icon="s-play" label="New Game" x-on:click="startGame()" />
                </div>
            </div>
        </div>
    @endvolt
</x-layouts.app>
