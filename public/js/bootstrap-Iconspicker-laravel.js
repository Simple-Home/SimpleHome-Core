window.addEventListener('load', function () {
    document.querySelectorAll('.iconButton').forEach(item => {
        item.querySelector('input').setAttribute("name", "icon");
        item.onclick = function () {
            var popName = item.getAttribute("aria-describedby");
            var pop = document.querySelector("#" + popName);
            pop.querySelector(".btn-next").addEventListener('mouseup', function() {  
                setTimeout( function () {
                    pop.querySelectorAll('.btn-icon').forEach(item2 => {
                        item2.addEventListener('mouseup', function() {
                            item.querySelector('input').value = item2.value;
                            item.form.submit();
                        });
                    });
                }, 1);
            });
            pop.querySelector(".btn-previous").addEventListener('mouseup', function() {
                setTimeout( function () {
                    pop.querySelectorAll('.btn-icon').forEach(item2 => {
                        item2.addEventListener('mouseup', function() {
                            item.querySelector('input').value = item2.value;
                            item.form.submit();
                        });
                    });
                }, 1);
            });
            pop.querySelector(".search-control").addEventListener('input', function() {
                setTimeout( function () {
                    pop.querySelectorAll('.btn-icon').forEach(item2 => {
                        item2.addEventListener('mouseup', function() {
                            item.querySelector('input').value = item2.value;
                            item.form.submit();
                        });
                    });
                }, 1000);
            });
            pop.querySelectorAll('.btn-icon').forEach(item2 => {
                item2.addEventListener('mouseup', function() {
                    item.querySelector('input').value = item2.value;
                    item.form.submit();
                });
            });
        };
    });
});