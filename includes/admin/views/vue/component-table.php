<div>

    <div class="tablenav top">

        <div class="alignleft actions bulkactions">
            <label for="bulk-action-selector-top" class="screen-reader-text"><?php _e( 'Select bulk action', 'best-contact-form' ); ?></label>
            <select name="action" v-model="bulkAction">
                <option value="-1"><?php _e( 'Bulk Actions', 'best-contact-form' ); ?></option>
                <option value="delete"><?php _e( 'Delete Entries', 'best-contact-form' ); ?></option>
            </select>

            <button class="button action" v-on:click.prevent="handleBulkAction"><?php _e( 'Apply', 'best-contact-form' ); ?></button>
        </div>

        <div class="alignleft actions">
            <a class="button" :href="'admin-post.php?action=bcf_export_form_entries&selected_forms=' + id + '&_wpnonce=' + nonce" style="margin-top: 0;"><span class="dashicons dashicons-download" style="margin-top: 4px;"></span> <?php _e( 'Export Entries', 'best-contact-form' ); ?></a>
        </div>

        <div class="tablenav-pages">

            <span v-if="totalItems" class="displaying-num">{{ totalItems }} <?php _e( 'items', 'best-contact-form' ); ?></span>

            <span class="pagination-links">
                <span v-if="isFirstPage()" class="tablenav-pages-navspan" aria-hidden="true">«</span>
                <a v-else class="first-page" href="#" @click.prevent="goFirstPage()"><span class="screen-reader-text"><?php _e( 'First page', 'best-contact-form' ); ?></span><span aria-hidden="true">«</span></a>

                <span v-if="currentPage == 1" class="tablenav-pages-navspan" aria-hidden="true">‹</span>
                <a v-else class="prev-page" href="#" @click.prevent="goToPage('prev')"><span class="screen-reader-text"><?php _e( 'Previous page', 'best-contact-form' ); ?></span><span aria-hidden="true">‹</span></a>

                <span class="screen-reader-text"><?php _e( 'Current Page', 'best-contact-form' ); ?></span><input @keydown.enter.prevent="goToPage(pageNumberInput)" class="current-page" id="current-page-selector" v-model="pageNumberInput" type="text" value="1" size="1" aria-describedby="table-paging"> <?php _e( 'of', 'best-contact-form' ); ?> <span class="total-pages">{{ totalPage }}</span>

                <span v-if="currentPage == totalPage" class="tablenav-pages-navspan" aria-hidden="true">›</span>
                <a v-else class="next-page" href="#" @click.prevent="goToPage('next')"><span class="screen-reader-text"><?php _e( 'Next page', 'best-contact-form' ); ?></span><span aria-hidden="true">›</span></a>

                <span v-if="isLastPage()" class="tablenav-pages-navspan" aria-hidden="true">»</span>
                <a v-else class="last-page" href="#" @click.prevent="goLastPage()"><span class="screen-reader-text"><?php _e( 'Last page', 'best-contact-form' ); ?></span><span aria-hidden="true">»</span></a>
            </span>
        </div>
    </div>

    <table class="wp-list-table widefat fixed striped wpuf-contact-form">
        <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column">
                    <input type="checkbox" v-model="selectAll">
                </td>
                <th class="col-entry-id"><?php _e( 'ID', 'best-contact-form' ); ?></th>
                <th v-for="(header, index) in columns">{{ header }}</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td id="cb" class="manage-column column-cb check-column">
                    <input type="checkbox" v-model="selectAll">
                </td>
                <th class="col-entry-id"><?php _e( 'ID', 'best-contact-form' ); ?></th>
                <th v-for="(header, index) in columns">{{ header }}</th>
                <th class="col-entry-details"><?php _e( 'Actions', 'best-contact-form' ); ?></th>
            </tr>
        </tfoot>
        <tbody>
            <tr v-if="loading">
                <td v-bind:colspan="columnLength + 3"><?php _e( 'Loading...', 'best-contact-form' ); ?></td>
            </tr>
            <tr v-if="!items.length && !loading">
                <td v-bind:colspan="columnLength + 3"><?php _e( 'No entries found!', 'best-contact-form' ); ?></td>
            </tr>
            <tr v-for="(entry, index) in items">
                <th scope="row" class="check-column">
                    <input type="checkbox" name="post[]" v-model="checkedItems" :value="entry.id">
                </th>
                <th class="col-entry-id">
                    <router-link :to="{ name: 'formEntriesSingle', params: { entryid: entry.id }}">#{{ entry.id }}</router-link>
                </th>
                <td v-for="(header, index) in columns">{{ entry.fields[index] }}</td>
                <th class="col-entry-details">
                    <router-link :to="{ name: 'formEntriesSingle', params: { entryid: entry.id }}"><?php _e( 'Details', 'best-contact-form' ); ?></router-link>
                </th>
            </tr>
        </tbody>
    </table>

    <div class="tablenav bottom">
        <div class="alignleft actions bulkactions">
            <label for="bulk-action-selector-top" class="screen-reader-text"><?php _e( 'Select bulk action', 'best-contact-form' ); ?></label>
            <select name="action" v-model="bulkAction">
                <option value="-1"><?php _e( 'Bulk Actions', 'best-contact-form' ); ?></option>
                <option value="delete"><?php _e( 'Delete Entries', 'best-contact-form' ); ?></option>
            </select>

            <button class="button action" v-on:click.prevent="handleBulkAction"><?php _e( 'Apply', 'best-contact-form' ); ?></button>
        </div>

        <div class="tablenav-pages">

            <span v-if="totalItems" class="displaying-num">{{ totalItems }} <?php _e( 'items', 'best-contact-form' ); ?></span>

            <span class="pagination-links">
                <span v-if="isFirstPage()" class="tablenav-pages-navspan" aria-hidden="true">«</span>
                <a v-else class="first-page" href="#" @click.prevent="goFirstPage()"><span class="screen-reader-text"><?php _e( 'First page', 'best-contact-form' ); ?></span><span aria-hidden="true">«</span></a>

                <span v-if="currentPage == 1" class="tablenav-pages-navspan" aria-hidden="true">‹</span>
                <a v-else class="prev-page" href="#" @click.prevent="goToPage('prev')"><span class="screen-reader-text"><?php _e( 'Previous page', 'best-contact-form' ); ?></span><span aria-hidden="true">‹</span></a>

                <span class="screen-reader-text"><?php _e( 'Current Page', 'best-contact-form' ); ?></span><input @keydown.enter.prevent="goToPage(pageNumberInput)" class="current-page" id="current-page-selector" v-model="pageNumberInput" type="text" value="1" size="1" aria-describedby="table-paging"> of <span class="total-pages">{{ totalPage }}</span>

                <span v-if="currentPage == totalPage" class="tablenav-pages-navspan" aria-hidden="true">›</span>
                <a v-else class="next-page" href="#" @click.prevent="goToPage('next')"><span class="screen-reader-text"><?php _e( 'Next page', 'best-contact-form' ); ?></span><span aria-hidden="true">›</span></a>

                <span v-if="isLastPage()" class="tablenav-pages-navspan" aria-hidden="true">»</span>
                <a v-else class="last-page" href="#" @click.prevent="goLastPage()"><span class="screen-reader-text"><?php _e( 'Last page', 'best-contact-form' ); ?></span><span aria-hidden="true">»</span></a>
            </span>
        </div>
    </div>
</div>