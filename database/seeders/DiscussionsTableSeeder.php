<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Discussion;
use App\Models\DiscussionReplies;

class DiscussionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$general = Discussion::create([
			"category_id" => 1,
			"slug" => "general-discussion-1713620623",
			"title" => "General Discussion",
			"content" => "# Welcome to General Discussion!\n\n\n\n## What is this for?\nThe general discussion is for all topics that does not involve anything from our beloved school. In here, you can talk about stuff like games, fashion, hobbies, etc.\n\n## Rules\nRules are ***generally*** simple ~~pun not intended~~ but for the most part, it\'s all about being civil and respectful.\n1. All discussions could be anything, even general school related topics that may fall in a narrower category.\n2. Politics are **allowed** but keep the comments/replies civil and respectful.\n3. Refrain from starting inappropriate discussions.\n4. Images must not contain inappropriate or NSFW content.\n5. If any violations are done, please report them by using the `report` button under the vertical ellipsis button at the top-right corner of each post.\n\n![Vertical Ellipsis](https://static.thenounproject.com/png/3137368-200.png)\n\n6. All discussions will be publicly available and will be visible to everyone. However, users will have their respective privacies respected by other users due to force anonymity provided by the forums. This will, however, not be the case to admins who could see your provided personal information.\n\n\n***NOTE:*** This rules are subject to change and update once the other features are properly implemented.\n\n## Guides\n\n### Formats\nFormatting your post is allowed but limited to allow 8192 characters at most. This is due to the database limitations currently and will not be adjusted until posted. This limitation extends to your formatting so be sure to watch your character count.\n\n#### Text Formats\n* **Bold** - \\*\\*Bold\\*\\*\n* *Italic* - \\*Italic\\*\n* ~~Strikethrough~~ - \\~\\~Strikethrough\\~\\~\n* `Code` - \\`Code\\`\n\n#### Heading Formats\n* # Heading 1\n* ## Heading 2\n* ### Heading 3\n* #### Heading 4\n* ##### Heading 5\n* ###### Heading 6\n\n#### Text Block Formats\n* ```Code Blocks``` - \\`\\`\\`Code Blocks\\`\\`\\`\n* >Blockquote - \\>Blockquote\n\n#### Attachments/Misc\n###### Unordered List\n```\n* Item 1\n* Item 2\n* Item 2.1\n```\n**(Output)**\n* Item 1\n* Item 2\n* Item 2.1\n\n###### Ordered List\n```\n1. Item 1\n2. Item 2\n1. Item 2.1\n```\n**(Output)**\n1. Item 1\n2. Item 2\n1. Item 2.1\n\n###### Mix List\n```\n1. OL 1\n2. OL 2\n* UL 1\n* UL 2\n\n* UL 1\n* UL 2\n1. OL 1\n2. OL 2\n```\n**(Output)**\n1. OL 1\n2. OL 2\n* UL 1\n* UL 2\n\n* UL 1\n* UL 2\n1. OL 1\n2. OL 2\n\n###### Checkbox\n```\n- [ ] Unchecked Checkbox\n- [x] Checked Checkbox\n```\n**(Output)**\n- [ ] Unchecked Checkbox\n- [x] Checked Checkbox\n\n###### Horizontal Line\n**(Output)**\n***\n\n###### Links\n```\n[General Discussion](/discussions/category/general/general-discussion-1713620623)\n```\n**(Output)**\n\n[General Discussion](https://innotech-03f0c051d428.herokuapp.com/discussions/category/general/general-discussion-1713086002)\n\n###### Images\n```\n![Image (Approved Meme GIF)](https://media1.tenor.com/m/A-ozELwp694AAAAC/thumbs-thumbs-up-kid.gif)\n```\n**(Output)**\n\n![Image (Approved Meme GIF)](https://media1.tenor.com/m/A-ozELwp694AAAAC/thumbs-thumbs-up-kid.gif)",
			"posted_by" => 1,
			"created_at" => "2024-04-20 21:43:43",
		]);

		DiscussionReplies::factory()
			->count(rand(2, 15))
			->discussionId($general->id)
			->randomEdit($general->created_at);

        Discussion::factory()
			->count(25)
			->randomDates()
			->create();
    }
}
