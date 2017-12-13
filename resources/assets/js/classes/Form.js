import Errors from "./Errors"

class Form {
    /**
     * Create a new Form instance.
     *
     * @param {object} data
     */
    constructor(data) {
        this.populateData(data)

        this.errors = new Errors()
    }

    /**
     * Polulate form fields.
     *
     * @param {object} data
     */
    populateData(data) {
        this.fields = data

        this.original = Object.assign({}, this.fields)
    }

    /**
     * Fetch all relevant data for the form.
     */
    data() {
        let data = {}

        for (let property in this.original) {
            data[property] = this[property]
        }

        return data
    }

    /**
     * Reset the form fields.
     */
    reset() {
        this.fields = Object.assign({}, this.original)

        this.errors.clear()
    }

    /**
     * Send a POST request to the given URL.
     * .
     * @param {string} url
     */
    post(url) {
        return this.submit("post", url)
    }

    /**
     * Send a PUT request to the given URL.
     * .
     * @param {string} url
     */
    put(url) {
        return this.submit("put", url)
    }

    /**
     * Send a PATCH request to the given URL.
     * .
     * @param {string} url
     */
    patch(url) {
        return this.submit("patch", url)
    }

    /**
     * Send a DELETE request to the given URL.
     * .
     * @param {string} url
     */
    delete(url) {
        return this.submit("delete", url)
    }

    /**
     * Handle a successful form submission.
     *
     * @param {object} data
     */
    onSuccess(data) {
        this.reset()
    }

    /**
     * Handle a failed form submission.
     *
     * @param {object} errors
     */
    onFail(errors) {
        this.errors.record(errors)
    }
}

export default Form
