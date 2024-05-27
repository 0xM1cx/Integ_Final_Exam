<style>
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
    }

    .rating input {
        display: none;
    }

    .rating label {
        cursor: pointer;
        font-size: 2rem;
        color: #ddd;
    }

    .rating input:checked~label,
    .rating label:hover,
    .rating label:hover~label {
        color: #f5c518;
    }
</style>
<section id="services" class="services">
    <div class="container">
        <div class="section-title">
            <h2>Book List</h2>
        </div>

        <!-- Button trigger modal -->
        <button type="button" class="btn text-white bg-black" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add a Book
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add a book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="./view/create.php" method="POST">
                            <div class="form-group">
                                <label for="title">Book Title</label>
                                <input name="title" type="text" class="form-control" id="title" placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label for="synopsis">Book Synopsis</label>
                                <textarea name="synopsis" class="form-control" id="synopsis" rows="4" placeholder="Enter book synopsis here"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="author">Author</label>
                                <input name="author" type="text" class="form-control" id="author" placeholder="Enter author">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <div class="rating">
                                    <input type="radio" name="rating" id="star5" value="5" required><label for="star5" title="5 stars">&#9733;</label>
                                    <input type="radio" name="rating" id="star4" value="4"><label for="star4" title="4 stars">&#9733;</label>
                                    <input type="radio" name="rating" id="star3" value="3"><label for="star3" title="3 stars">&#9733;</label>
                                    <input type="radio" name="rating" id="star2" value="2"><label for="star2" title="2 stars">&#9733;</label>
                                    <input type="radio" name="rating" id="star1" value="1"><label for="star1" title="1 star">&#9733;</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>Title</th>
                    <th>Synopsis</th>
                    <th>Author</th>
                    <th>Rating</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require "./model/database.php";
                $sql = "SELECT * FROM books";
                $res = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                    <tr>
                        <td>
                            <p class="fw-normal mb-1"><?php echo $row['title']; ?></p>
                        </td>
                        <td>
                            <p class="fw-normal mb-1">
                                <?php
                                $synopsis = htmlspecialchars($row['synopsis'], ENT_QUOTES, 'UTF-8');
                                if (strlen($synopsis) > 100) {
                                    $synopsis = substr($synopsis, 0, 100) . "...";
                                    echo $synopsis;
                                    echo '<a href="#" class="read-more"> Read More</a>';
                                } else {
                                    echo $synopsis;
                                }
                                ?>
                            </p>
                        </td>
                        <td>
                            <p class="fw-normal mb-1"><?php echo $row['author']; ?></p>
                        </td>
                        <td>
                            <?php
                            $rating = (int)$row['rating'];
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) {
                                    echo '<span class="text-warning">&#9733;</span>';
                                } else {
                                    echo '<span class="text-muted">&#9733;</span>';
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-link btn-sm btn-rounded edit-btn" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['book_id']; ?>">
                                Edit
                            </button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editModal<?php echo $row['book_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['book_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?php echo $row['book_id']; ?>">Edit Book</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="./view/update.php" method="POST">
                                        <div class="form-group">
                                            <label for="edit-title">Book Title</label>
                                            <input name="edit-title" type="text" class="form-control" id="edit-title" placeholder="Enter title" value="<?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="edit-synopsis">Book Synopsis</label>
                                            <textarea name="edit-synopsis" class="form-control" id="edit-synopsis" rows="4" placeholder="Enter book synopsis here"><?php echo htmlspecialchars($row['synopsis'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit-author">Author</label>
                                            <input name="edit-author" type="text" class="form-control" id="edit-author" placeholder="Enter author" value="<?php echo htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8'); ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Rating</label>
                                            <div class="rating">
                                                <?php
                                                $rating = (int)$row['rating'];
                                                for ($i = 1; $i <= 5; $i++) {
                                                    $checked = ($i == $rating) ? 'checked' : '';
                                                    echo '<input type="radio" name="edit-rating" id="edit-star' . $i . '" value="' . $i . '" ' . $checked . '><label for="edit-star' . $i . '" title="' . $i . ' stars">&#9733;</label>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                                        <div class="modal-footer">
                                            <a href="./view/delete.php?book_id=<?php echo $row['book_id']; ?>" class="btn btn-danger">Delete</a>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>