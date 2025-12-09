<a href="${post.link}">
    <li>
        <p class="features-list-top">${index + 1}</p>
        <img class="features-list-logo-image" src="${post.meta?.logo || ""}" alt="${post.title.rendered}" />

        <p class="text-line features-list-name">${post.title.rendered}</p>
    </li>
</a>