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
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, {
                value: '',
                isMerged: false,
                animate: '',
                color: '',
            }, ],
            score: 0,
            bestScore: $persist(0),
            starters: [2, 2, 2, 2, 2, 2, 2, 4],
            startGame() {
                this.resetGame();
                this.newValue();
                this.newValue();
                {{-- let all = [2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048, 4096, 8192, 16384, 32768, 65536];
                for (index = 0; index <= 15; index++) {
                    this.newValue(index, all[index]);
                } --}}
            },
            resetGame() {
                this.score = 0;
                for (index = 0; index <= 15; index++) {
                    this.board[index].value = '';
                }
            },
            randomIntFromInterval(min, max) {
                return Math.floor(Math.random() * (max - min + 1) + min);
            },
            newValue(overrideIndex = null, overrideValue = null) {
                let index = this.randomIntFromInterval(0, 15);
                while (this.board[index].value !== '') {
                    index = this.randomIntFromInterval(0, 15);
                }
                let starterIndex = this.randomIntFromInterval(0, 5);
                index = overrideIndex ?? index;
                this.board[index].value = overrideValue ?? this.starters[starterIndex];
                this.animateCell(index, 'animate-scale-up');
            },
            isEmptyCell(index) {
                return this.board[index].value === '';
            },
            replaceCell(index, newIndex) {
                console.log('runpgfijn');
                console.log(index);
                console.log(newIndex);
                let oldValue = this.board[index].value;
                let newValue = this.board[newIndex].value;
                console.log('artrt');
                if (newValue === '' && index !== newIndex) {
                    console.log('replace: ' + newIndex);
                    this.board[newIndex].value = '' + oldValue;
                    this.board[index].value = '';
                    {{-- this.animateCell(index, 'animate-slide-up'); --}}
                }
            },
            mergeCell(index, newIndex) {
                let oldValue = parseInt(this.board[index].value);
                let oldIsMerged = this.board[index].isMerged;
                let newValue = parseInt(this.board[newIndex].value);
                let newIsMerged = this.board[newIndex].isMerged;

                if (oldValue === newValue && index !== newIndex && !oldIsMerged && !newIsMerged) {
                    console.log('merge: ' + newIndex);
                    let mergeValue = oldValue + newValue;
                    this.board[newIndex].value = '' + mergeValue;
                    this.board[newIndex].isMerged = true;
                    this.board[index].value = '';
                    this.animateCell(newIndex, 'animate-pop-out');
                    this.score += mergeValue;
                    this.bestScore = this.score > this.bestScore ? this.score : this.bestScore;
                }
                {{-- console.table(this.board); --}}
            },
            moveCell(index, newIndex) {
                console.log('old: ' + index);
                console.log('new: ' + newIndex);
                console.log('+++++++++++++++++++++++++++++++++++++++++++');
                this.replaceCell(index, newIndex);
                this.mergeCell(index, newIndex);
            },
            fixNewIndex(index, newIndex, fix) {
                let oldValue = parseInt(this.board[index].value);
                let newValue = parseInt(this.board[newIndex].value);

                if (!this.isEmptyCell(newIndex) && oldValue !== newValue) {
                    newIndex = newIndex + fix;
                }

                return newIndex;
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
                for (index = 4; index <= 15; index++) {
                    if (this.isEmptyCell(index)) {
                        continue;
                    }

                    let oldIndex = index;
                    let newIndex = index;
                    do {
                        newIndex -= 4;
                    } while (this.isEmptyCell(newIndex) && newIndex >= 4);

                    newIndex = this.fixNewIndex(oldIndex, newIndex, 4);
                    this.moveCell(index, newIndex);
                    {{-- this.animateCell(oldIndex, 'animate-slide-up');
                    setTimeout(() => this.moveCell(oldIndex, newIndex), 100); --}}
                }
            },
            moveDown(depth = 0) {
                console.log('down');
                for (index = 11; index >= 0; index--) {
                    if (this.isEmptyCell(index)) {
                        continue;
                    }

                    let oldIndex = index;
                    let newIndex = index;
                    do {
                        newIndex += 4;
                    } while (this.isEmptyCell(newIndex) && newIndex <= 11);

                    newIndex = this.fixNewIndex(index, newIndex, -4);
                    this.moveCell(index, newIndex);
                    {{-- this.animateCell(oldIndex, 'animate-slidedown');
                    setTimeout(() => this.moveCell(oldIndex, newIndex), 200); --}}
                }

            },
            moveLeft(depth = 0) {
                console.log('left');
                const skip = [0, 4, 8, 12];
                for (index = 0; index <= 15; index++) {
                    if (this.isEmptyCell(index) || skip.includes(index)) {
                        continue;
                    }

                    let oldIndex = index;
                    let newIndex = index;
                    do {
                        newIndex -= 1;
                    } while (this.isEmptyCell(newIndex) && !skip.includes(newIndex));

                    newIndex = this.fixNewIndex(index, newIndex, 1);
                    this.moveCell(index, newIndex);
                    {{-- this.animateCell(oldIndex, 'animate-slide-left');
                    setTimeout(() => this.moveCell(oldIndex, newIndex), 200); --}}
                }
            },
            moveRight(depth = 0) {
                console.log('right');
                const skip = [3, 7, 11, 15];
                for (index = 15; index >= 0; index--) {
                    if (this.isEmptyCell(index) || skip.includes(index)) {
                        continue;
                    }

                    let oldIndex = index;
                    let newIndex = index;
                    do {
                        newIndex += 1;
                    } while (this.isEmptyCell(newIndex) && !skip.includes(newIndex));

                    newIndex = this.fixNewIndex(index, newIndex, -1);
                    this.moveCell(index, newIndex);
                    {{-- this.animateCell(oldIndex, 'animate-slide-right');
                    setTimeout(() => this.moveCell(oldIndex, newIndex), 200); --}}
                }
            },
            animateCell(index, animation) {
                console.log(index);
                console.log(animation);
                this.board[index].animate = animation;
                setTimeout(() => this.board[index].animate = '', 200);
            },
        }" x-init="startGame()">
            <x-header title="2K48" size="text-3xl text-primary">
                <x-slot:actions>
                    <x-theme-toggle class="btn" title="Toggle Theme" darkTheme="night" lightTheme="retro" />
                    <x-button label="" class="" x-on:click="$wire.drawerSettings = true" responsive
                        icon="o-adjustments-horizontal" title="Settings" />
                </x-slot:actions>
            </x-header>

            <div class="m-auto w-full h-[calc(100vh-8rem)] justify-center items-center flex flex-col gap-8 px-4"
                x-on:keydown.up.window="move('up')" x-swipe:up="move('up')" x-on:keydown.down.window="move('down')"
                x-swipe:down="move('down')" x-on:keydown.left.window="move('left')" x-swipe:left="move('left')"
                x-on:keydown.right.window="move('right')" x-swipe:right="move('right')">

                <div class="flex justify-end w-full gap-4 px-2">
                    <div></div>
                    <div class="p-2 font-bold text-center text-white rounded bg-slate-600 min-w-24">
                        <div class="text-gray-400">Score</div>
                        <div class="text-xl font-bold" x-text="score"></div>
                    </div>
                    <div class="p-2 font-bold text-center text-white rounded min-w-24 bg-slate-600">
                        <div class="text-gray-400">Best</div>
                        <div class="text-xl font-bold" x-text="bestScore"></div>
                    </div>
                </div>

                <div class="grid grid-cols-4 grid-rows-4 border-2 rounded border-stone-700">
                    <template x-for="(cell, index) in board">
                        <div class="flex items-center justify-center w-20 h-20 border-2 lg:w-20 lg:h-20 border-stone-700">
                            <div class="flex items-center justify-center font-bold text-white rounded-lg w-18 h-18"
                                x-text="cell.value"
                                x-bind:class="{
                                    'bg-amber-800 text-4xl': cell.value == 2,
                                    'bg-amber-600 text-4xl': cell.value == 4,
                                    'bg-amber-400 text-4xl': cell.value == 8,
                                    'bg-red-400 text-4xl': cell.value == 16,
                                    'bg-red-600 text-4xl': cell.value == 32,
                                    'bg-blue-800 text-4xl': cell.value == 64,
                                    'bg-blue-400 text-2xl': cell.value == 128,
                                    'bg-lime-400 text-2xl': cell.value == 256,
                                    'bg-lime-800 text-2xl': cell.value == 512,
                                    'bg-secondary text-xl': cell.value == 1024,
                                    'bg-primary text-xl': cell.value == 2048,
                                    'bg-indigo-400 text-xl': cell.value == 4096,
                                    'bg-indigo-600 text-xl': cell.value == 8192,
                                    'bg-gray-800 text-xl': cell.value == 16384,
                                    'animate-pop-out': cell.animate == 'animate-pop-out',
                                    'animate-scale-up': cell.animate == 'animate-scale-up',
                                    'animate-slide-up': cell.animate == 'animate-slide-up',
                                }">
                            </div>
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
