<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAS HI TECH</title>
    <link rel="stylesheet" href="{{asset('assets/fontawesome')}}/css/all.min.css"> <!-- https://fontawesome.com/ -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet"> <!-- https://fonts.google.com/ -->
    <link href="{{asset('assets/css')}}/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('assets/css')}}/templatemo-xtra-blog.css" rel="stylesheet">

    <script src="{{asset('js/toastify-js.js')}}"></script>
    <script src="{{asset('js/axios.min.js')}}"></script>
    <script src="{{asset('js/config.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.js')}}"></script>
</head>
<body>
<ul class="nav justify-content-end">
    <li class="nav-item">
        <a class="nav-link active" href="{{route('login')}}">Login</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('register')}}">Register</a>
    </li>
</ul>

<div class="row row-cols-1 row-cols-md-3 g-4" id="post" style="background-color: #6da6d3">

</div>

<nav aria-label="Page navigation example">
    <ul class="pagination" id="paginateList">
        <li class="page-item"><a class="page-link" id="previous" onclick="changePage(currentPage - 1)">Previous</a></li>

        <li class="page-item"><a class="page-link" id="next" onclick="changePage(currentPage + 1)">Next</a></li>
    </ul>
</nav>

<script>
    let currentPage = 1;
    const pageSize = 1;

    async function getList(page) {
        const postsElement = document.getElementById('post');
        postsElement.innerHTML = '';

        const response = await axios.get('/PostGet', {
            params: {
                page: page,
                pageSize: pageSize,
            },
        });

        response.data.data.forEach(function (item) {
            let row = `<div class="col mb-4 ml-0">
                        <div class="card mb-6">
                            <img src="${item.image}" class="card-img-top" alt="..." style="width: 100%; height: 300px" >
                            <div class="card-body">
                                <h5 class="card-title">${item.title}</h5>
                                <p class="card-text">${item.body.substring(0, 100) + '...'}</p>
                                <a href="/singlePost/${item.id}" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>`;

            postsElement.innerHTML += row;
        });

        updatePaginationLinks();
    }

    function updatePaginationLinks() {
        const paginateListElement = document.getElementById('paginateList');


        paginateListElement.innerHTML = '';


        const previousLink = document.createElement('li');
        previousLink.classList.add('page-item');
        previousLink.innerHTML = `<a class="page-link" id="previous" onclick="changePage(currentPage - 1)">Previous</a>`;
        paginateListElement.appendChild(previousLink);


        for (let i = 1; i <= 3; i++) {
            const pageLink = document.createElement('li');
            pageLink.classList.add('page-item');
            pageLink.innerHTML = `<a class="page-link" onclick="changePage(${i})" id="page${i}">${i}</a>`;
            paginateListElement.appendChild(pageLink);
        }


        const nextLink = document.createElement('li');
        nextLink.classList.add('page-item');
        nextLink.innerHTML = `<a class="page-link" id="next" onclick="changePage(currentPage + 1)">Next</a>`;
        paginateListElement.appendChild(nextLink);
    }

    function changePage(page) {
        if (page >= 1) {
            currentPage = page;
            getList(currentPage);
        }
    }


    getList(currentPage);
</script>
</body>
</html>
