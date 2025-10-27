document.addEventListener("DOMContentLoaded", async () => {

    let sharedBlogId = null;
    async function getSharedBlogId() {
    if (sharedBlogId) return sharedBlogId;

    const params = new URLSearchParams(window.location.search);
    let postId = params.get("id");

    sharedBlogId = postId;
    console.log("Blog ID dùng chung:", sharedBlogId);
    return sharedBlogId;
    }

    const blogId = await getSharedBlogId()

/** =================================================== */
    const relatedBlogs = document.querySelector(".blog-grid");
    try {
        const res = await fetch("http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/blogs?per_page=100");
        const blogs = await res.json();

        blogs.forEach((blog) => {
            const meta = blog.meta || {};
            const bg_short_desc = meta.bg_short_desc || "";
            const title = blog?.title?.rendered || "Banner";
            const bg_avatar = meta.bg_avatar || "";
            const bg_author = meta.bg_author || "";
            const bg_date = meta.bg_date || "";
            const bg_author_logo = meta.bg_author_logo || "";

            const bannerHTML = `
                <div class="blog-card">
                <div class="blog-image">
                    <img
                    src="${bg_avatar}"
                    alt=""
                    />
                </div>
                <div class="blog-content">
                <h3 class="text-line blog-title">
                    ${title}
                </h3>
                <p class="text-line blog-description">
                    ${bg_short_desc}
                </p>
                <div class="blog-meta">
                    <img
                    class="blog-meta-avatar"
                    src="${bg_author_logo}"
                    alt=""
                    />
                    <span>${bg_author} | ${bg_date}</span>
                </div>
                <a href="http://localhost/PXP_SSW/wordpress/blog_detail/?id=${blog.id}" class="read-more"
                    ><span>Read more</span>
                    <i style="font-size: 10px" class="fa-solid fa-chevron-right"></i
                ></a>
                </div>
            </div>
            `;

            relatedBlogs.insertAdjacentHTML("beforeend", bannerHTML);
        });


        

    } catch (error) {
        console.error("Lỗi khi tải banner:", error);
    }

/**===================================================== */
    const sidebar = document.querySelector(".sidebar-widget");
    try {
        const res = await fetch("http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/blogs?per_page=100");
        const blogs = await res.json();

        blogs.forEach((blog) => {
            const meta = blog.meta || {};
            const bg_short_desc = meta.bg_short_desc || "";
            const title = blog?.title?.rendered || "Banner";
            const bg_avatar = meta.bg_avatar || "";
            const bg_author = meta.bg_author || "";
            const bg_date = meta.bg_date || "";
            const bg_author_logo = meta.bg_author_logo || "";

            const bannerHTML = `
                <div class="post-item">
                    <div class="post-thumbnail">
                        <img
                        src="${bg_avatar}"
                        alt="Post"
                        />
                    </div>
                    <div class="post-info">
                        <h4>
                        <a class="text-line text-blog-tilte" href="http://localhost/PXP_SSW/wordpress/blog_detail/?id=${blog.id}"
                            >${title}</a
                        >
                        </h4>
                        <div class="post-date">
                        <i class="fa-regular fa-clock"></i> ${bg_date}
                        </div>
                    </div>
                </div>
            `;

            sidebar.insertAdjacentHTML("beforeend", bannerHTML);
        });
    } catch (error) {
        console.error("Lỗi khi tải banner:", error);
    }

/** ==================================================== */
    const blog_header = document.querySelector(".article-header");
    try {
        const res = await fetch(`http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/blogs/${blogId}`);
        const blog = await res.json();

        
        const meta = blog.meta || {};
        const bg_short_desc = meta.bg_short_desc || "";
        const title = blog?.title?.rendered || "Banner";
        const bg_avatar = meta.bg_avatar || "";
        const bg_author = meta.bg_author || "";
        const bg_date = meta.bg_date || "";
        const bg_author_logo = meta.bg_author_logo || "";

        const tagIds = blog.blog_tag || [];

        let tagsHTML = "";
        if (tagIds.length > 0) {
        const tagPromises = tagIds.map(async (id) => {
            const tagRes = await fetch(`http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/blog_tag/${id}`);
            const tagData = await tagRes.json();
            return `<span class="tag">${tagData.name}</span>`;
        });

        const tags = await Promise.all(tagPromises);
        tagsHTML = tags.join("");
        }

            const bannerHTML = `
                <div class="article-tags">
                ${tagsHTML || "<span class='tag'>No Tag</span>"}
                </div>
                <h1>${title}</h1>
                <div class="article-meta">
                <div class="article-meta-left">
                    <span class="article-views">
                    <i class="fa-solid fa-eye"></i>
                    46 lượt xem
                    </span>
                    <div class="author">
                    <img src="${bg_author_logo}" alt="Author" />
                    <span>${bg_author} — ${bg_date}</span>
                    </div>
                </div>
                <div class="article-actions">
                    <a href="https://x.com/"><i class="fa-brands fa-twitter"></i></a>
                    <a href="https://www.facebook.com/index.php/"><i class="fa-brands fa-facebook"></i></a>
                    <a href="https://ca.linkedin.com/"><i class="fa-brands fa-linkedin"></i></a>
                </div>
                </div>
            `;

            blog_header.insertAdjacentHTML("beforeend", bannerHTML);
    } catch (error) {
        console.error("Lỗi khi tải banner:", error);
    }



/** ==================================================== */


   const blogDesc = document.querySelector("#article-content");

  try {
    const res = await fetch(`http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/blogs/${blogId}`);
    const blog = await res.json();

    const meta = blog.meta || {};
    const desc = meta._blog_desc || "<p>Không có nội dung mô tả.</p>";

    // Render nội dung trước
    blogDesc.innerHTML = desc;

    // Sau đó thêm TOC vào DOM
    generateTableOfContents();
  } catch (error) {
    console.error("Lỗi khi tải blog:", error);
  }


  const breadcrumb = document.querySelector(".breadcrumb_blog");
    try {
        const res = await fetch(`http://localhost/PXP_SSW/wordpress/wp-json/wp/v2/blogs/${blogId}`);
        const blog = await res.json();
        
            const title = blog?.title?.rendered || "Banner";

            const bannerHTML = `
                <a href="http://localhost/PXP_SSW/wordpress/"><i class="fa-solid fa-house"></i> Streaming Sites</a> /
                <a href="http://localhost/PXP_SSW/wordpress/blog/">Blog</a> /
                <span>${title}</span>
            `;

            breadcrumb.insertAdjacentHTML("beforeend", bannerHTML);
        
    } catch (error) {
        console.error("Lỗi khi tải banner:", error);
    }
});

function generateTableOfContents() {
  const content = document.getElementById("article-content");
  if (!content) return;

  const headings = content.querySelectorAll("h2, h3");
  if (headings.length === 0) return;

  // Tạo TOC mới và chèn lên đầu nội dung
  const toc = document.createElement("div");
  toc.className = "table-of-contents";
  toc.innerHTML = `
    <div class="toc-header">
      <h3><i class="fa-solid fa-list-ul"></i> Nội dung chính</h3>
      <i class="fa-solid fa-chevron-down toc-toggle"></i>
    </div>
    <div class="toc-content">
      <ul class="toc-list"></ul>
    </div>
  `;
  content.prepend(toc);

  const tocList = toc.querySelector(".toc-list");
  const tocHeader = toc.querySelector(".toc-header");
  const tocContent = toc.querySelector(".toc-content");
  const toggleIcon = toc.querySelector(".toc-toggle");

  // Gắn sự kiện dropdown
  tocHeader.addEventListener("click", () => {
    tocContent.classList.toggle("show");
    toggleIcon.classList.toggle("rotate");
  });


  headings.forEach((heading, index) => {
    const id = `section-${index}`;
    heading.id = id;

    const li = document.createElement("li");
    const a = document.createElement("a");
    a.href = `#${id}`;
    a.innerHTML = `<span class="toc-number">${index + 1}.</span> <span>${heading.textContent}</span>`;

    if (heading.tagName === "H3") li.classList.add("sub-item");

    li.appendChild(a);
    tocList.appendChild(li);
  });
}



