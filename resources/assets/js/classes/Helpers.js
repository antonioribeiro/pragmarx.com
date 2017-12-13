class Helpers {
    clone(object) {
        return JSON.parse(JSON.stringify(object))
    }
}

window.dd = function() {
    console.log(
        "-------------------------------------------------------------------- DEBUG",
    )

    console.log(...arguments)
}

export default Helpers
