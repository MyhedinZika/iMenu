function form_checkRequired(elementId) {
    var element = document.getElementById(elementId)

    if (element && element.value.length === 0) {
        form_showError(elementId, true)

        return false
    } else {
        form_showError(elementId, false)

        return true
    }
}

function form_checkRequiredRadio(elementName) {
    var radioList = document.querySelectorAll('input[name="' + elementName + '"][type=radio]')

    if (radioList) {
        var radioArray = Array.from(radioList)
        var radio = null
        var isSelected = false

        for (radio of radioArray) {
            if (radio.checked === true) {
                isSelected = true
                break
            }
        }

        if (!isSelected) {
            form_showError(elementName, true)

            return false
        } else {
            form_showError(elementName, false)

            return true
        }
    }

    console.log('warning: element not found, returning true')
    return true
}

function form_findErrorMessageElement(elementId) {
    return document.querySelector('span.error-message[data-for="' + elementId + '"]')
}

function form_showError(elementId, show) {
    var element = form_findErrorMessageElement(elementId)

    if (element) {
        element.style.display = show ? 'block' : 'none'
    } else {
        console.log('warning: error element not found')
    }
}