import { Blowfish } from "javascript-blowfish"

class BrowserStorage {
    constructor() {
        this.blowfish = new Blowfish("some crypto key here")
    }

    clear(item) {
        localStorage.removeItem(this.getKey(item))
    }

    put(item, object) {
        localStorage.setItem(this.getKey(item), this.encrypt(object))
    }

    get(item) {
        try {
            const data = this.decrypt(localStorage.getItem(this.getKey(item)))

            return data
        } catch (exception) {
            return null
        }
    }

    decrypt(encrypted) {
        if (!encrypted) {
            return null
        }

        const data = this.blowfish.base64Decode(
            this.blowfish.decrypt(this.blowfish.base64Decode(encrypted)),
        )

        const loaded = JSON.parse(data)

        return loaded
    }

    encrypt(object) {
        if (!object) {
            return null
        }

        return this.blowfish.base64Encode(
            this.blowfish.encrypt(
                this.blowfish.base64Encode(JSON.stringify(object)),
            ),
        )
    }

    getKey(item) {
        return "home24." + this.getAppId() + "." + item
    }

    getAppId() {
        return "some app id here"
    }
}

export default BrowserStorage
