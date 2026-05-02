<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use Illuminate\Database\Seeder;

class CaseStudyAiVoiceInterviewSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            'overview' => '<p>HilDes designed and built a fully autonomous AI-powered interview platform that conducts, evaluates, and scores candidates in real time — without human intervention.</p><p>The system replaces manual screening calls with an intelligent voice-based interview pipeline, capable of handling high-volume candidate assessments simultaneously while maintaining consistency, speed, and objectivity.</p><p><strong>Core capabilities:</strong></p><ul><li>Real-time AI voice interviews</li><li>Automated question delivery and response handling</li><li>Intelligent candidate evaluation using AI models</li><li>Pre-screening and post-interview scoring</li><li>Concurrent interview session management</li></ul>',
            'challenge' => '<p>Traditional recruitment workflows are time-consuming, inconsistent, and difficult to scale.</p><p><strong>Key problems:</strong></p><ul><li>Manual interviews limit hiring throughput</li><li>Inconsistent evaluation across candidates</li><li>Delays in screening large applicant volumes</li><li>High operational cost for recruitment teams</li><li>Lack of structured and comparable candidate data</li></ul><p>The client needed a system that could conduct interviews autonomously, evaluate candidates objectively, handle high concurrency, and deliver instant structured results.</p>',
            'approach' => '<p>We engineered a real-time AI voice interaction system combining:</p><ul><li>Speech recognition</li><li>Conversational AI</li><li>Telephony infrastructure</li><li>Real-time processing pipelines</li></ul><p>The platform was designed as a fully automated decision-making system, not just a chatbot.</p>',
            'infrastructure' => '<p><strong>Real-time AI interview flow:</strong></p><ol><li>Candidate receives or initiates call via Twilio</li><li>Voice input processed using Deepgram (STT)</li><li>Transcribed text sent to GPT engine</li><li>GPT generates next question and evaluates response</li><li>Response converted back into voice</li><li>Conversation continues dynamically</li><li>Final scoring and report generated automatically</li></ol>',
            'stabilization' => '<p><strong>Real-time voice processing technologies:</strong></p><ul><li>Deepgram (Speech-to-Text)</li><li>Twilio Voice API</li><li>WebSockets for real-time streaming</li></ul><p><strong>Implementation highlights:</strong></p><ul><li>Sub-second voice-to-text conversion</li><li>Continuous streaming of audio data</li><li>Real-time conversational loop</li></ul><p><strong>Impact:</strong> natural interactions, no lag in conversation flow, and scalable voice processing.</p>',
            'devops' => '<p><strong>WebSocket-based session management:</strong></p><ul><li>Real-time session handling using WebSockets</li><li>Concurrent interview support</li><li>State management across sessions</li></ul><p><strong>Impact:</strong> ability to run multiple interviews simultaneously with stable real-time communication and scalable system behavior.</p>',
            'quality' => '<p><strong>AI evaluation engine:</strong></p><ul><li>Powered by OpenAI GPT models</li><li>Context-aware question generation</li><li>Dynamic follow-up questions</li><li>Real-time response analysis</li></ul><p><strong>Features:</strong></p><ul><li>Candidate answer evaluation</li><li>Scoring based on predefined criteria</li><li>Context retention across conversation</li><li>Structured decision-making logic</li></ul><p><strong>Impact:</strong> consistent evaluation, reduced interviewer bias, and adaptive interviews.</p>',
            'process' => '<p><strong>Pre-interview screening module:</strong></p><ul><li>Configurable screening criteria</li><li>Qualification-based filtering</li><li>Automated eligibility checks</li></ul><p><strong>Impact:</strong> only relevant candidates proceed, reduced interview load, and faster hiring pipeline.</p><p><strong>Post-interview scoring and reporting:</strong></p><ul><li>Candidate score breakdown</li><li>Strengths and weaknesses analysis</li><li>Structured evaluation report</li><li>Ready-to-use hiring insights</li></ul><p><strong>Impact:</strong> instant decision-making, data-driven hiring, and standardized comparison.</p>',
            'security' => '<p><strong>Decision integrity and reliability controls:</strong></p><ul><li>Standardized scoring rubric enforcement</li><li>Structured transcript-based evaluation trails</li><li>Session-level state controls for interview integrity</li><li>Repeatable evaluation criteria across all candidates</li></ul><p><strong>Impact:</strong> stronger process trust, auditability, and dependable autonomous screening operations.</p>',
            'performance' => '<p><strong>Performance and scalability achievements:</strong></p><ul><li>Sub-second latency in voice processing</li><li>High concurrency support</li><li>Real-time data streaming</li><li>Horizontally scalable architecture</li></ul><p><strong>Result:</strong> system can handle large-scale recruitment campaigns without degradation.</p>',
            'modernization' => '<p><strong>Technology stack:</strong></p><ul><li>OpenAI GPT</li><li>Deepgram STT</li><li>Twilio Voice API</li><li>WebSockets</li><li>React.js</li><li>Node.js</li></ul><p><strong>Deliverables:</strong></p><ul><li>End-to-end AI voice interview platform</li><li>Real-time voice processing pipeline</li><li>GPT-powered interview and scoring engine</li><li>Pre-interview screening module</li><li>Post-interview evaluation reports</li><li>WebSocket-based concurrent session system</li><li>Scalable backend architecture</li></ul>',
            'results' => '<ul><li>Fully automated interview process</li><li>Massive reduction in hiring time</li><li>Consistent and unbiased candidate evaluation</li><li>Ability to conduct interviews at scale</li><li>Data-driven hiring decisions</li></ul>',
            'outcome' => '<p>The client transformed recruitment from a manual, slow process into a fully automated AI-driven hiring system capable of screening and evaluating candidates at scale with precision and speed.</p>',
        ];

        $slug = 'ai-voice-interview-system';
        $nextOrder = ((int) CaseStudy::query()->max('display_order')) + 1;

        $caseStudy = CaseStudy::query()->updateOrCreate(
            ['slug' => $slug],
            [
                'title' => 'AI Voice Interview System',
                'slug' => $slug,
                'tagline' => 'Fully Autonomous Candidate Screening & Evaluation at Scale',
                'short_description' => 'HilDes delivered a fully autonomous AI voice interview platform that conducts real-time interviews, evaluates candidate responses, and provides structured scoring at scale.',
                'sections_json' => $sections,
                'is_published' => true,
                'display_order' => $nextOrder,
            ]
        );

        $caseStudy->seoMeta()->updateOrCreate(
            [],
            [
                'seo_enabled' => true,
                'is_indexable' => true,
                'include_in_sitemap' => true,
                'slug' => $caseStudy->slug,
                'canonical_url' => url('/case-studies/'.$caseStudy->slug),
                'meta_title' => 'AI Voice Interview System Case Study | HilDes',
                'meta_description' => 'Explore how HilDes built an autonomous AI voice interview system for high-volume, unbiased candidate screening and real-time scoring.',
                'meta_keywords' => 'AI voice interview, autonomous hiring, recruitment automation, GPT interview system, Twilio Deepgram integration, HilDes case study',
                'focus_keyword' => 'ai voice interview system case study',
                'robots_directive' => 'index,follow',
                'og_title' => 'AI Voice Interview System | Case Study',
                'og_description' => 'A real-world AI hiring platform with autonomous interviews, real-time scoring, and scalable concurrent sessions.',
                'twitter_title' => 'AI Voice Interview System | HilDes',
                'twitter_description' => 'Case study on autonomous candidate screening with AI voice interviews and scalable hiring operations.',
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'Article',
                            'headline' => 'AI Voice Interview System',
                            'description' => 'Case study of an autonomous AI voice interview and candidate evaluation platform.',
                            'author' => [
                                '@type' => 'Organization',
                                'name' => 'HilDes',
                            ],
                        ],
                    ],
                ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ]
        );
    }
}

