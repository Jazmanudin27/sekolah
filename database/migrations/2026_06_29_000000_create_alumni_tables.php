<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Posts (News & Articles)
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('category'); // sekolah, alumni, pengumuman, artikel
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 2. Events (Agenda)
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->dateTime('date');
            $table->string('location');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // 3. Event RSVPs
        Schema::create('event_rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('status'); // hadir, tidak_hadir, ragu_ragu
            $table->timestamps();
            $table->unique(['user_id', 'event_id']);
        });

        // 4. Donations (Campaigns)
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('target_amount', 15, 2);
            $table->decimal('raised_amount', 15, 2)->default(0.00);
            $table->string('type'); // pembangunan, beasiswa, sosial, bencana
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // 5. Donation Transactions
        Schema::create('donation_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('amount', 15, 2);
            $table->string('donor_name');
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->string('payment_method');
            $table->text('message')->nullable();
            $table->timestamps();
        });

        // 6. Careers (Job Listings)
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company');
            $table->text('description');
            $table->string('type'); // fulltime, parttime, internship, freelance
            $table->string('location');
            $table->string('contact');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 7. Businesses (Alumni Enterprises)
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->text('description');
            $table->string('product_image')->nullable();
            $table->string('contact');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 8. Forum Topics
        Schema::create('forum_topics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 9. Forum Replies
        Schema::create('forum_replies', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignId('forum_topic_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 10. Galleries
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type'); // foto, video
            $table->string('url');
            $table->string('category'); // reuni, sosial, seminar, sekolah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('forum_replies');
        Schema::dropIfExists('forum_topics');
        Schema::dropIfExists('businesses');
        Schema::dropIfExists('careers');
        Schema::dropIfExists('donation_transactions');
        Schema::dropIfExists('donations');
        Schema::dropIfExists('event_rsvps');
        Schema::dropIfExists('events');
        Schema::dropIfExists('posts');
    }
};
