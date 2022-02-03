
// Soal 1
space("Soal 1")

const count = input => {

    let result = input.reduce((a, c) => a.set(c, (a.get(c) || 0) + 1), new Map());

    result = [...result]

    const dataFiltered = []
    let amount = 0;

    result.forEach(e => {
        if (e[1] > 1) {
            dataFiltered.push(e[0])
        }
    });

    result.forEach(e => {
        amount +=  Math.floor(e[1] / 2)
    });

    // console.log(dataFiltered);
    console.log(amount);
}

// Soal 1 a
space("a")
count([10,20,20,10,10,30,50,10,20])
// Soal 1 b
space("b")
count([6,5,2,3,5,2,2,1,1,5,1,3,3,3,5])
space("c")
// Soal 1 c
count([1,1,3,1,2,1,3,3,3,3])



// Soal 2

space("Soal2")

var format = /^[a-zA-Z0-9\-\.\,\?]+$/;

const countWord = kalimat => {
            
    let kalimatArr = kalimat.split(" ");
    let kalimatFilter = kalimatArr.filter(e => {
        return format.test(e)
    })

    return kalimatFilter.length

}

// soal 2 a
space("a")
console.log(countWord("Saat meng*ecat tembok, Agung dib_antu oleh Raihan."));
// soal 2 b
space("b")
console.log(countWord("Berapa u(mur minimal[ untuk !mengurus ktp?"));
// soal 2 c
space("c")
console.log(countWord("Masing-masing anak mendap(atkan uang jajan ya=ng be&rbeda."));


function space (title) {
    console.log(`------${title}-----`);
}
