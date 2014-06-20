String.prototype.pick = function(min, max) {
    var n, chars = '';

    if (typeof max === 'undefined') {
        n = min;
    } else {
        n = min + Math.floor(Math.random() * (max - min));
    }

    for (var i = 0; i < n; i++) {
        chars += this.charAt(Math.floor(Math.random() * this.length));
    }

    return chars;
};


// Credit to @Christoph: http://stackoverflow.com/a/962890/464744
String.prototype.shuffle = function() {
    var array = this.split('');
    var tmp, current, top = array.length;

    if (top) while (--top) {
        current = Math.floor(Math.random() * (top + 1));
        tmp = array[current];
        array[current] = array[top];
        array[top] = tmp;
    }

    return array.join('');
};

if (document.getElementById('generate_password')) {
    document.getElementById('generate_password').onclick = function(e) {
        e.preventDefault();
        var lowercase = 'abcdefghijklmnopqrstuvwxyz';
        var uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var numbers = '0123456789';

        var password = [];
        var r = 0;
        for (var x = 0; x < 8; x++) {
            r = Math.floor(Math.random() * 3);

            switch (r) {
                case 1:
                    password.push(lowercase.pick(1));
                    break;

                case 2:
                    password.push(uppercase.pick(1));
                    break;

                default:
                    password.push(numbers.pick(1));
                    break;
            }
        }

        document.getElementById('password').value = password.join('').shuffle();
    }

}