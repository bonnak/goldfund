export class Pagination {
	constructor(data) {
        this.total = data.total;
        this.per_page = data.per_page;
        this.current_page = data.current_page;
        this.last_page = data.last_page;
        this.next_page_url = data.next_page_url;
        this.prev_page_url = data.prev_page_url;
        this.from = data.from;
        this.to = data.to;
      }
}