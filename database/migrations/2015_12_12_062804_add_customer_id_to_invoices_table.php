public function up()
{
    Schema::table('invoices', function (Blueprint $table) {
        $table->unsignedBigInteger('customer_id')->after('id');
        $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('invoices', function (Blueprint $table) {
        $table->dropForeign(['customer_id']);
        $table->dropColumn('customer_id');
    });
}
