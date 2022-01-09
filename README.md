# game-of-life-book
A textbook for Conway's Game of Life. Compiled PDF and official homepage is located at **[conwaylife.com/book](https://conwaylife.com/book)**.

Compile from main.tex. To compile just a chapter or two at a time (recommended when making changes, since compilation of the full book takes so long), comment out any unnecessary chapters in main.tex prior to compilation. For example, to compile the book without Chapter 3: Oscillators, change the following line:

\include{oscillators}

in main.tex to:

%\include{oscillators}
